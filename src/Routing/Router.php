<?php

namespace App\Routing;

use App\RoutingConfig;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;

class Router
{
    /**
     * @var string[]
     */
    private $newConnectionHandlerTypes = [];

    /**
     * @var string[]
     */
    private $connectionClosedHandlerTypes = [];

    /**
     * @var array
     */
    private $messageHandlerTypesByMessageType = [];

    /**
     * @var string[]
     */
    private $messageHandlerTypesForAnyMessage = [];

    /**
     * @var object[]
     */
    private $services = [];

    public function addService(object $service): void
    {
        $this->services[get_class($service)] = $service;
    }

    public function addNewConnectionHandler(string $handler): void
    {
        if(is_a($handler, NewConnectionHandler::class, true)) {
            $this->newConnectionHandlerTypes[] = $handler;
        }
    }

    public function addClosedConnectionHandler(string $handler): void
    {
        if(is_a($handler, ConnectionClosedHandler::class, true)) {
            $this->connectionClosedHandlerTypes[] = $handler;
        }
    }

    public function addMessageHanlderByType(string $handler, string $messageType): void
    {
        if(is_a($handler, MessageHandler::class, true)) {
            $this->messageHandlerTypesByMessageType[$messageType][] = $handler;
        }
    }

    public function addHandlerForAnyMessageType(string $handler): void
    {
        if(is_a($handler, MessageHandler::class, true)) {
            $this->messageHandlerTypesForAnyMessage[] = $handler;
        }
    }



    public function handleNewConnection(Request $request): void
    {
        foreach ($this->newConnectionHandlerTypes as $handlerType) {
            /** @var NewConnectionHandler $handler */
            $handler = $this->initHandler($handlerType);
            $handler->handle($request);
        }
    }

    public function handleClosedConnection(int $connectionId): void
    {
        foreach ($this->connectionClosedHandlerTypes as $handlerType) {
            /** @var ConnectionClosedHandler $handler */
            $handler = $this->initHandler($handlerType);
            $handler->handle($connectionId);
        }
    }

    public function handleMessage(Frame $frame): void
    {
        foreach ($this->messageHandlerTypesForAnyMessage as $handlerType) {
            /** @var MessageHandler $handler */
            $handler = $this->initHandler($handlerType);
            $handler->handle($frame);
        }

        $messageType = RoutingConfig::getMessageTypeFromRequest($frame);

        if(!isset($this->messageHandlerTypesByMessageType[$messageType])) {
            $this->messageHandlerTypesByMessageType[$messageType] = [];
        }

        foreach ($this->messageHandlerTypesByMessageType[$messageType] as $handlerType) {
            /** @var MessageHandler $handler */
            $handler = $this->initHandler($handlerType);
            $handler->handle($frame);
        }
    }

    /**
     * @param class-string $handlerType
     * @throws \ReflectionException
     */
    private function initHandler(string $handlerType): object {
        $reflection = new \ReflectionClass($handlerType);
        $constructor = $reflection->getConstructor();

        if($constructor === null) {
            return new $handlerType();
        }

        $parametersToPass = [];
        foreach ($constructor->getParameters() as $parameter) {
            $parameterClassType = $parameter->getType();
            if($parameterClassType === null) {
                throw new \Exception();
            }
            $parameterClassName = $parameterClassType->getName();

            if(array_key_exists($parameterClassName, $this->services)) {
                $parametersToPass[] = $this->services[$parameterClassName];
            } else {
                throw new \Exception();
            }
        }

        return new $handlerType(...$parametersToPass);
    }
}