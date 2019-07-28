<?php

namespace App\Helper;

use Swoole\Channel;

class RequestLimiter
{
    /**
     * @var Channel
     */
    private $userIds;

    const MAX_SAVED_RECORDS_COUNT = 5;

    const MAX_REQUESTS_BY_USER = 5;

    public function __construct() {
        $this->userIds = new Channel(1024 * 64);
    }

    /**
     * Check if there are too many requests from user
     *  and make a record of request from that user
     *
     * @param int $userId
     * @return bool
     */
    public function checkIsRequestAllowed(int $userId) {
        $requestsCount = $this->getRequestsCountByUser($userId);
        $this->addRecord($userId);
        if ($requestsCount >= self::MAX_REQUESTS_BY_USER) return false;
        return true;
    }

    /**
     * @param int $userId
     * @return int
     */
    private function getRequestsCountByUser(int $userId) {
        $channelRecordsCount = $this->userIds->stats()['queue_num'];
        $requestsCount = 0;

        for ($i = 0; $i < $channelRecordsCount; $i++) {
            $userIdFromChannel = $this->userIds->pop();
            $this->userIds->push($userIdFromChannel);
            if ($userIdFromChannel === $userId) {
                $requestsCount++;
            }
        }

        return $requestsCount;
    }

    /**
     * @param int $userId
     */
    private function addRecord(int $userId): void {
        $recordsCount = $this->userIds->stats()['queue_num'];

        if ($recordsCount >= self::MAX_SAVED_RECORDS_COUNT) {
            $this->userIds->pop();
        }

        $this->userIds->push($userId);
    }
}
