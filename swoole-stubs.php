<?php
/**
 * 使用Base模式，业务代码在Reactor进程中直接执行
 * <p>这种模式就是传统的异步非阻塞Server。
 * <p>在Reactor内直接回调PHP的函数。
 * <p>如果回调函数中有阻塞操作会导致Server退化为同步模式。
 * <p>worker_num参数对与BASE模式仍然有效，swoole会启动多个Reactor进程。
 */
define('SWOOLE_BASE',4);
define('SWOOLE_THREAD',2);

/**
 * 使用进程模式，业务代码在Worker进程中执行
 */
define('SWOOLE_PROCESS',3);
define('SWOOLE_IPC_UNSOCK',1);
define('SWOOLE_IPC_MSGQUEUE',2);
define('SWOOLE_IPC_PREEMPTIVE',3);

/**
 * 创建tcp socket
 */
define('SWOOLE_SOCK_TCP',1);

/**
 * 创建tcp ipv6 socket
 */
define('SWOOLE_SOCK_TCP6',3);

/**
 * 创建udp socket
 */
define('SWOOLE_SOCK_UDP',2);

/**
 *
 */
define('SWOOLE_SOCK_UDP6',4);
define('SWOOLE_SOCK_UNIX_DGRAM',5);
define('SWOOLE_SOCK_UNIX_STREAM',6);
define('SWOOLE_TCP',1);
define('SWOOLE_TCP6',3);
define('SWOOLE_UDP',2);
define('SWOOLE_UDP6',4);
define('SWOOLE_UNIX_DGRAM',5);
define('SWOOLE_UNIX_STREAM',6);

/**
 * 同步客户端
 */
define('SWOOLE_SOCK_SYNC',0);

/**
 * 异步客户端
 */
define('SWOOLE_SOCK_ASYNC',1);
define('SWOOLE_SYNC',2048);
define('SWOOLE_ASYNC',1024);
define('SWOOLE_KEEP',4096);
define('SWOOLE_SSL',512);
define('SWOOLE_SSLv3_METHOD',1);
define('SWOOLE_SSLv3_SERVER_METHOD',2);
define('SWOOLE_SSLv3_CLIENT_METHOD',3);
define('SWOOLE_SSLv23_METHOD',0);
define('SWOOLE_SSLv23_SERVER_METHOD',4);
define('SWOOLE_SSLv23_CLIENT_METHOD',5);
define('SWOOLE_TLSv1_METHOD',6);
define('SWOOLE_TLSv1_SERVER_METHOD',7);
define('SWOOLE_TLSv1_CLIENT_METHOD',8);
define('SWOOLE_TLSv1_1_METHOD',9);
define('SWOOLE_TLSv1_1_SERVER_METHOD',10);
define('SWOOLE_TLSv1_1_CLIENT_METHOD',11);
define('SWOOLE_TLSv1_2_METHOD',12);
define('SWOOLE_TLSv1_2_SERVER_METHOD',13);
define('SWOOLE_TLSv1_2_CLIENT_METHOD',14);
define('SWOOLE_DTLSv1_METHOD',15);
define('SWOOLE_DTLSv1_SERVER_METHOD',16);
define('SWOOLE_DTLSv1_CLIENT_METHOD',17);
define('SWOOLE_EVENT_READ',512);
define('SWOOLE_EVENT_WRITE',1024);
define('SWOOLE_VERSION','1.9.15');
define('SWOOLE_AIO_BASE',0);
define('SWOOLE_AIO_LINUX',1);
define('SIGHUP',1);
define('SIGINT',2);
define('SIGQUIT',3);
define('SIGILL',4);
define('SIGTRAP',5);
define('SIGABRT',6);
define('SIGBUS',7);
define('SIGFPE',8);
define('SIGKILL',9);
define('SIGUSR1',10);
define('SIGSEGV',11);
define('SIGUSR2',12);
define('SIGPIPE',13);
define('SIGALRM',14);
define('SIGTERM',15);
define('SIGSTKFLT',16);
define('SIGCHLD',17);
define('SIGCONT',18);
define('SIGSTOP',19);
define('SIGTSTP',20);
define('SIGTTIN',21);
define('SIGTTOU',22);
define('SIGURG',23);
define('SIGXCPU',24);
define('SIGXFSZ',25);
define('SIGVTALRM',26);
define('SIGPROF',27);
define('SIGWINCH',28);
define('SIGIO',29);
define('SIGPWR',30);
define('SIGSYS',31);

/**
 * 文件锁
 */
define('SWOOLE_FILELOCK',2);

/**
 * 互斥锁
 */
define('SWOOLE_MUTEX',3);

/**
 * 信号量
 */
define('SWOOLE_SEM',4);

/**
 * 读写锁
 */
define('SWOOLE_RWLOCK',1);

/**
 * 自旋锁
 */
define('SWOOLE_SPINLOCK',5);

/**
 * WebSocket数据帧类型: UTF-8文本字符数据
 */
define('WEBSOCKET_OPCODE_TEXT',1);

/**
 * WebSocket数据帧类型: 二进制数据
 */
define('WEBSOCKET_OPCODE_BINARY',2);

/**
 * WebSocket数据帧类型: ping类型数据
 */
define('WEBSOCKET_OPCODE_PING',9);

/**
 * WebSocket连接状态：连接进入等待握手
 */
define('WEBSOCKET_STATUS_CONNECTION',1);

/**
 * WebSocket连接状态：正在握手
 */
define('WEBSOCKET_STATUS_HANDSHAKE',2);

/**
 * WebSocket连接状态：已握手成功等待浏览器发送数据帧
 */
define('WEBSOCKET_STATUS_FRAME',3);
define('WEBSOCKET_STATUS_ACTIVE',3);
define('SWOOLE_FAST_PACK',1);
function swoole_version(){}

function swoole_cpu_num(){}

function swoole_last_error(){}

/**
 * @param $fd[required]
 * @param $read_callback[required]
 * @param $write_callback[optional]
 * @param $events[optional]
 */
function swoole_event_add($fd,$read_callback,$write_callback=null,$events=null){}

/**
 * @param $fd[required]
 * @param $read_callback[optional]
 * @param $write_callback[optional]
 * @param $events[optional]
 */
function swoole_event_set($fd,$read_callback=null,$write_callback=null,$events=null){}

/**
 * @param $fd[required]
 */
function swoole_event_del($fd){}

function swoole_event_exit(){}

function swoole_event_wait(){}

/**
 * @param $fd[required]
 * @param $data[required]
 */
function swoole_event_write($fd,$data){}

/**
 * @param $callback[required]
 */
function swoole_event_defer($callback){}

/**
 * @param $ms[required]
 * @param $callback[required]
 * @param $param[optional]
 */
function swoole_timer_after($ms,$callback,$param=null){}

/**
 * @param $ms[required]
 * @param $callback[required]
 */
function swoole_timer_tick($ms,$callback){}

/**
 * @param $timer_id[required]
 */
function swoole_timer_exists($timer_id){}

/**
 * @param $timer_id[required]
 */
function swoole_timer_clear($timer_id){}

/**
 * @param $settings[required]
 */
function swoole_async_set($settings){}

/**
 * @param $filename[required]
 * @param $callback[required]
 * @param $chunk_size[optional]
 * @param $offset[optional]
 */
function swoole_async_read($filename,$callback,$chunk_size=null,$offset=null){}

/**
 * @param $filename[required]
 * @param $content[required]
 * @param $offset[optional]
 * @param $callback[optional]
 */
function swoole_async_write($filename,$content,$offset=null,$callback=null){}

/**
 * @param $filename[required]
 * @param $callback[required]
 */
function swoole_async_readfile($filename,$callback){}

/**
 * @param $filename[required]
 * @param $content[required]
 * @param $callback[optional]
 * @param $flags[optional]
 */
function swoole_async_writefile($filename,$content,$callback=null,$flags=null){}

/**
 * @param $domain_name[required]
 * @param $content[required]
 */
function swoole_async_dns_lookup($domain_name,$content){}

/**
 * @param $read_array[required]
 * @param $write_array[required]
 * @param $error_array[required]
 * @param $timeout[optional]
 */
function swoole_client_select($read_array,$write_array,$error_array,$timeout=null){}

/**
 * @param $read_array[required]
 * @param $write_array[required]
 * @param $error_array[required]
 * @param $timeout[optional]
 */
function swoole_select($read_array,$write_array,$error_array,$timeout=null){}

/**
 * @param $process_name[required]
 */
function swoole_set_process_name($process_name){}

function swoole_get_local_ip(){}

/**
 * @param $errno[required]
 */
function swoole_strerror($errno){}

function swoole_errno(){}

/**
 *@since 1.9.15
 */
namespace Swoole
{
    class Server
    {
        /**
         * @param $host      [required]
         * @param $port      [optional]
         * @param $mode      [optional]
         * @param $sock_type [optional]
         */
        public function __construct ($host, $port = NULL, $mode = NULL, $sock_type = NULL) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function listen ($host, $port, $sock_type) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function addlistener ($host, $port, $sock_type) { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        public function start () { }

        /**
         * @param $fd         [required]
         * @param $send_data  [required]
         * @param $reactor_id [optional]
         */
        public function send ($fd, $send_data, $reactor_id = NULL) { }

        /**
         * @param $ip            [required]
         * @param $port          [required]
         * @param $send_data     [required]
         * @param $server_socket [optional]
         */
        public function sendto ($ip, $port, $send_data, $server_socket = NULL) { }

        /**
         * @param $conn_fd   [required]
         * @param $send_data [required]
         */
        public function sendwait ($conn_fd, $send_data) { }

        /**
         * @param $fd [required]
         */
        public function exist ($fd) { }

        /**
         * @param $fd           [required]
         * @param $is_protected [optional]
         */
        public function protect ($fd, $is_protected = NULL) { }

        /**
         * @param $conn_fd  [required]
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($conn_fd, $filename, $offset = NULL, $length = NULL) { }

        /**
         * @param $fd    [required]
         * @param $reset [optional]
         */
        public function close ($fd, $reset = NULL) { }

        /**
         * @param $fd [required]
         */
        public function confirm ($fd) { }

        /**
         * @param $fd [required]
         */
        public function pause ($fd) { }

        /**
         * @param $fd [required]
         */
        public function resume ($fd) { }

        /**
         * @param $data            [required]
         * @param $worker_id       [optional]
         * @param $finish_callback [optional]
         */
        public function task ($data, $worker_id = NULL, $finish_callback = NULL) { }

        /**
         * @param $data      [required]
         * @param $timeout   [optional]
         * @param $worker_id [optional]
         */
        public function taskwait ($data, $timeout = NULL, $worker_id = NULL) { }

        /**
         * @param $tasks   [required]
         * @param $timeout [optional]
         */
        public function taskWaitMulti ($tasks, $timeout = NULL) { }

        /**
         * @param $data [required]
         */
        public function finish ($data) { }

        public function reload () { }

        public function shutdown () { }

        /**
         * @param $worker_id [optional]
         */
        public function stop ($worker_id = NULL) { }

        public function getLastError () { }

        /**
         * @param $reactor_id [required]
         */
        public function heartbeat ($reactor_id) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function connection_info ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function connection_list ($start_fd, $find_count = NULL) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function getClientInfo ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function getClientList ($start_fd, $find_count = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         * @param $param    [optional]
         */
        public function after ($ms, $callback, $param = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         */
        public function tick ($ms, $callback) { }

        /**
         * @param $timer_id [required]
         */
        public function clearTimer ($timer_id) { }

        /**
         * @param $callback [required]
         */
        public function defer ($callback) { }

        /**
         * @param $dst_worker_id [required]
         * @param $data          [required]
         */
        public function sendMessage ($dst_worker_id, $data) { }

        /**
         * @param $process [required]
         */
        public function addProcess ($process) { }

        public function stats () { }

        /**
         * @param $fd  [required]
         * @param $uid [required]
         */
        public function bind ($fd, $uid) { }


    }

    class Timer
    {
        /**
         * @param $ms       [required]
         * @param $callback [required]
         * @param $param    [optional]
         */
        public static function tick ($ms, $callback, $param = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         */
        public static function after ($ms, $callback) { }

        /**
         * @param $timer_id [required]
         */
        public static function exists ($timer_id) { }

        /**
         * @param $timer_id [required]
         */
        public static function clear ($timer_id) { }


    }

    class Event
    {
        /**
         * @param $fd             [required]
         * @param $read_callback  [required]
         * @param $write_callback [optional]
         * @param $events         [optional]
         */
        public static function add ($fd, $read_callback, $write_callback = NULL, $events = NULL) { }

        /**
         * @param $fd [required]
         */
        public static function del ($fd) { }

        /**
         * @param $fd             [required]
         * @param $read_callback  [optional]
         * @param $write_callback [optional]
         * @param $events         [optional]
         */
        public static function set ($fd, $read_callback = NULL, $write_callback = NULL, $events = NULL) { }

        public static function exit() { }

        /**
         * @param $fd   [required]
         * @param $data [required]
         */
        public static function write ($fd, $data) { }

        public static function wait () { }

        /**
         * @param $callback [required]
         */
        public static function defer ($callback) { }


    }

    class Async
    {
        /**
         * @param $filename   [required]
         * @param $callback   [required]
         * @param $chunk_size [optional]
         * @param $offset     [optional]
         */
        public static function read ($filename, $callback, $chunk_size = NULL, $offset = NULL) { }

        /**
         * @param $filename [required]
         * @param $content  [required]
         * @param $offset   [optional]
         * @param $callback [optional]
         */
        public static function write ($filename, $content, $offset = NULL, $callback = NULL) { }

        /**
         * @param $filename [required]
         * @param $callback [required]
         */
        public static function readFile ($filename, $callback) { }

        /**
         * @param $filename [required]
         * @param $content  [required]
         * @param $callback [optional]
         * @param $flags    [optional]
         */
        public static function writeFile ($filename, $content, $callback = NULL, $flags = NULL) { }

        /**
         * @param $domain_name [required]
         * @param $content     [required]
         */
        public static function dnsLookup ($domain_name, $content) { }

        /**
         * @param $settings [required]
         */
        public static function set ($settings) { }


    }

    class Exception extends \Exception
    {
        final private function __clone () { }

        /**
         * @param $message  [optional]
         * @param $code     [optional]
         * @param $previous [optional]
         */
        public function __construct ($message = NULL, $code = NULL, $previous = NULL) { }

        public function __wakeup () { }

        final public function getMessage () { }

        final public function getCode () { }

        final public function getFile () { }

        final public function getLine () { }

        final public function getTrace () { }

        final public function getPrevious () { }

        final public function getTraceAsString () { }

        public function __toString () { }


    }

    class Client
    {
        /**
         * @param $type  [required]
         * @param $async [optional]
         */
        public function __construct ($type, $async = NULL) { }

        public function __destruct () { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $host      [required]
         * @param $port      [optional]
         * @param $timeout   [optional]
         * @param $sock_flag [optional]
         */
        public function connect ($host, $port = NULL, $timeout = NULL, $sock_flag = NULL) { }

        /**
         * @param $size [optional]
         * @param $flag [optional]
         */
        public function recv ($size = NULL, $flag = NULL) { }

        /**
         * @param $data [required]
         * @param $flag [optional]
         */
        public function send ($data, $flag = NULL) { }

        /**
         * @param $dst_socket [required]
         */
        public function pipe ($dst_socket) { }

        /**
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($filename, $offset = NULL, $length = NULL) { }

        /**
         * @param $ip   [required]
         * @param $port [required]
         * @param $data [required]
         */
        public function sendto ($ip, $port, $data) { }

        public function sleep () { }

        public function wakeup () { }

        public function pause () { }

        public function resume () { }

        /**
         * @param $callback [optional]
         */
        public function enableSSL ($callback = NULL) { }

        public function getPeerCert () { }

        public function verifyPeerCert () { }

        public function isConnected () { }

        public function getsockname () { }

        public function getpeername () { }

        /**
         * @param $force [optional]
         */
        public function close ($force = NULL) { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }
    }

    class Process
    {
        /**
         * @param $callback                  [required]
         * @param $redirect_stdin_and_stdout [optional]
         * @param $pipe_type                 [optional]
         */
        public function __construct ($callback, $redirect_stdin_and_stdout = NULL, $pipe_type = NULL) { }

        public function __destruct () { }

        /**
         * @param $blocking [optional]
         */
        public static function wait ($blocking = NULL) { }

        /**
         * @param $signal_no [required]
         * @param $callback  [required]
         */
        public static function signal ($signal_no, $callback) { }

        /**
         * @param $usec [required]
         */
        public static function alarm ($usec) { }

        /**
         * @param $pid       [required]
         * @param $signal_no [optional]
         */
        public static function kill ($pid, $signal_no = NULL) { }

        /**
         * @param $nochdir [optional]
         * @param $noclose [optional]
         */
        public static function daemon ($nochdir = NULL, $noclose = NULL) { }

        /**
         * @param $cpu_settings [required]
         */
        public static function setaffinity ($cpu_settings) { }

        /**
         * @param $key  [required]
         * @param $mode [optional]
         */
        public function useQueue ($key, $mode = NULL) { }

        public function statQueue () { }

        public function freeQueue () { }

        public function start () { }

        /**
         * @param $data [required]
         */
        public function write ($data) { }

        public function close () { }

        /**
         * @param $size [optional]
         */
        public function read ($size = NULL) { }

        /**
         * @param $data [required]
         */
        public function push ($data) { }

        /**
         * @param $size [optional]
         */
        public function pop ($size = NULL) { }

        /**
         * @param $exit_code [optional]
         */
        public function exit($exit_code = NULL) { }

        /**
         * @param $exec_file [required]
         * @param $args      [required]
         */
        public function exec ($exec_file, $args) { }

        /**
         * @param $process_name [required]
         */
        public function name ($process_name) { }
    }

    class Table
    {
        /**
         * @param $table_size [required]
         */
        public function __construct ($table_size) { }

        /**
         * @param $name [required]
         * @param $type [required]
         * @param $size [optional]
         */
        public function column ($name, $type, $size = NULL) { }

        public function create () { }

        public function destroy () { }

        /**
         * @param $key   [required]
         * @param $value [required]
         */
        public function set ($key, $value) { }

        /**
         * @param $key   [required]
         * @param $field [optional]
         */
        public function get ($key, $field = NULL) { }

        public function count () { }

        /**
         * @param $key [required]
         */
        public function del ($key) { }

        /**
         * @param $key   [required]
         * @param $field [optional]
         */
        public function exist ($key, $field = NULL) { }

        /**
         * @param $key    [required]
         * @param $column [required]
         * @param $incrby [optional]
         */
        public function incr ($key, $column, $incrby = NULL) { }

        /**
         * @param $key    [required]
         * @param $column [required]
         * @param $decrby [optional]
         */
        public function decr ($key, $column, $decrby = NULL) { }

        public function rewind () { }

        public function next () { }

        public function current () { }

        public function key () { }

        public function valid () { }


    }

    class Lock
    {
        /**
         * @param $type     [optional]
         * @param $filename [optional]
         */
        public function __construct ($type = NULL, $filename = NULL) { }

        public function __destruct () { }

        public function lock () { }

        public function trylock () { }

        public function lock_read () { }

        public function trylock_read () { }

        public function unlock () { }
    }

    class Atomic
    {
        /**
         * @param $value [optional]
         */
        public function __construct ($value = NULL) { }

        /**
         * @param $add_value [optional]
         */
        public function add ($add_value = NULL) { }

        /**
         * @param $sub_value [optional]
         */
        public function sub ($sub_value = NULL) { }

        public function get () { }

        /**
         * @param $value [required]
         */
        public function set ($value) { }

        /**
         * @param $timeout [optional]
         */
        public function wait ($timeout = NULL) { }

        /**
         * @param $count [optional]
         */
        public function wakeup ($count = NULL) { }

        /**
         * @param $cmp_value [required]
         * @param $new_value [required]
         */
        public function cmpset ($cmp_value, $new_value) { }
    }

    class Buffer
    {
        /**
         * @param $size [optional]
         */
        public function __construct ($size = NULL) { }

        public function __destruct () { }

        public function __toString () { }

        /**
         * @param $offset [required]
         * @param $length [optional]
         * @param $seek   [optional]
         */
        public function substr ($offset, $length = NULL, $seek = NULL) { }

        /**
         * @param $offset [required]
         * @param $data   [required]
         */
        public function write ($offset, $data) { }

        /**
         * @param $offset [required]
         * @param $length [required]
         */
        public function read ($offset, $length) { }

        /**
         * @param $data [required]
         */
        public function append ($data) { }

        /**
         * @param $size [required]
         */
        public function expand ($size) { }

        public function recycle () { }

        public function clear () { }
    }

    class MySQL
    {
        public function __construct () { }

        public function __destruct () { }

        /**
         * @param $server_config [required]
         * @param $callback      [required]
         */
        public function connect ($server_config, $callback) { }

        /**
         * @param $callback [required]
         */
        public function begin ($callback) { }

        /**
         * @param $callback [required]
         */
        public function commit ($callback) { }

        /**
         * @param $callback [required]
         */
        public function rollback ($callback) { }

        /**
         * @param $sql      [required]
         * @param $callback [required]
         */
        public function query ($sql, $callback) { }

        public function close () { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }
    }

    class Mmap
    {
        /**
         * @param $filename [required]
         * @param $size     [optional]
         * @param $offset   [optional]
         */
        public static function open ($filename, $size = NULL, $offset = NULL) { }
    }

    class Channel
    {
        /**
         * @param $size [required]
         */
        public function __construct ($size) { }

        public function __destruct () { }

        /**
         * @param $data [required]
         */
        public function push ($data) { }

        public function pop () { }

        public function stats () { }


    }

    class Serialize
    {
        /**
         * @param $data [required]
         * @param $flag [optional]
         */
        public static function pack ($data, $flag = NULL) { }

        /**
         * @param $string [required]
         * @param $args   [optional]
         */
        public static function unpack ($string, $args = NULL) { }
    }

    class Redis
    {
        public function __construct () { }

        public function __destruct () { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }

        /**
         * @param $host     [required]
         * @param $port     [required]
         * @param $callback [required]
         */
        public function connect ($host, $port, $callback) { }

        public function close () { }

        /**
         * @param $command [required]
         * @param $params  [required]
         */
        public function __call ($command, $params) { }


    }

}

/**
 *@since 1.9.15
 */
namespace Swoole\Connection
{
    class Iterator
    {
        public function rewind () { }

        public function next () { }

        public function current () { }

        public function key () { }

        public function valid () { }

        public function count () { }

        /**
         * @param $fd [required]
         */
        public function offsetExists ($fd) { }

        /**
         * @param $fd [required]
         */
        public function offsetGet ($fd) { }

        /**
         * @param $fd    [required]
         * @param $value [required]
         */
        public function offsetSet ($fd, $value) { }

        /**
         * @param $fd [required]
         */
        public function offsetUnset ($fd) { }
    }
}

namespace Swoole\Server
{
    class Port
    {
        private function __construct () { }

        public function __destruct () { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }
    }
}

/**
 *@since 1.9.15
 */
namespace Swoole\Http
{
    class Client
    {
        /**
         * @param $host [required]
         * @param $port [optional]
         * @param $ssl  [optional]
         */
        public function __construct ($host, $port = NULL, $ssl = NULL) { }

        public function __destruct () { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $method [required]
         */
        public function setMethod ($method) { }

        /**
         * @param $headers [required]
         */
        public function setHeaders ($headers) { }

        /**
         * @param $cookies [required]
         */
        public function setCookies ($cookies) { }

        /**
         * @param $data [required]
         */
        public function setData ($data) { }

        /**
         * @param $path     [required]
         * @param $name     [required]
         * @param $type     [optional]
         * @param $filename [optional]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function addFile ($path, $name, $type = NULL, $filename = NULL, $offset = NULL, $length = NULL) { }

        /**
         * @param $path     [required]
         * @param $callback [required]
         */
        public function execute ($path, $callback) { }

        /**
         * @param $data   [required]
         * @param $opcode [optional]
         * @param $finish [optional]
         */
        public function push ($data, $opcode = NULL, $finish = NULL) { }

        /**
         * @param $path     [required]
         * @param $callback [required]
         */
        public function get ($path, $callback) { }

        /**
         * @param $path     [required]
         * @param $data     [required]
         * @param $callback [required]
         */
        public function post ($path, $data, $callback) { }

        /**
         * @param $path     [required]
         * @param $callback [required]
         */
        public function upgrade ($path, $callback) { }

        /**
         * @param $path     [required]
         * @param $file     [required]
         * @param $callback [required]
         * @param $offset   [optional]
         */
        public function download ($path, $file, $callback, $offset = NULL) { }

        public function isConnected () { }

        public function close () { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }
    }

    class Server extends \Swoole\Server
    {
        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }

        public function start () { }

        /**
         * @param $host      [required]
         * @param $port      [optional]
         * @param $mode      [optional]
         * @param $sock_type [optional]
         */
        public function __construct ($host, $port = NULL, $mode = NULL, $sock_type = NULL) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function listen ($host, $port, $sock_type) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function addlistener ($host, $port, $sock_type) { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $fd         [required]
         * @param $send_data  [required]
         * @param $reactor_id [optional]
         */
        public function send ($fd, $send_data, $reactor_id = NULL) { }

        /**
         * @param $ip            [required]
         * @param $port          [required]
         * @param $send_data     [required]
         * @param $server_socket [optional]
         */
        public function sendto ($ip, $port, $send_data, $server_socket = NULL) { }

        /**
         * @param $conn_fd   [required]
         * @param $send_data [required]
         */
        public function sendwait ($conn_fd, $send_data) { }

        /**
         * @param $fd [required]
         */
        public function exist ($fd) { }

        /**
         * @param $fd           [required]
         * @param $is_protected [optional]
         */
        public function protect ($fd, $is_protected = NULL) { }

        /**
         * @param $conn_fd  [required]
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($conn_fd, $filename, $offset = NULL, $length = NULL) { }

        /**
         * @param $fd    [required]
         * @param $reset [optional]
         */
        public function close ($fd, $reset = NULL) { }

        /**
         * @param $fd [required]
         */
        public function confirm ($fd) { }

        /**
         * @param $fd [required]
         */
        public function pause ($fd) { }

        /**
         * @param $fd [required]
         */
        public function resume ($fd) { }

        /**
         * @param $data            [required]
         * @param $worker_id       [optional]
         * @param $finish_callback [optional]
         */
        public function task ($data, $worker_id = NULL, $finish_callback = NULL) { }

        /**
         * @param $data      [required]
         * @param $timeout   [optional]
         * @param $worker_id [optional]
         */
        public function taskwait ($data, $timeout = NULL, $worker_id = NULL) { }

        /**
         * @param $tasks   [required]
         * @param $timeout [optional]
         */
        public function taskWaitMulti ($tasks, $timeout = NULL) { }

        /**
         * @param $data [required]
         */
        public function finish ($data) { }

        public function reload () { }

        public function shutdown () { }

        /**
         * @param $worker_id [optional]
         */
        public function stop ($worker_id = NULL) { }

        public function getLastError () { }

        /**
         * @param $reactor_id [required]
         */
        public function heartbeat ($reactor_id) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function connection_info ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function connection_list ($start_fd, $find_count = NULL) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function getClientInfo ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function getClientList ($start_fd, $find_count = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         * @param $param    [optional]
         */
        public function after ($ms, $callback, $param = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         */
        public function tick ($ms, $callback) { }

        /**
         * @param $timer_id [required]
         */
        public function clearTimer ($timer_id) { }

        /**
         * @param $callback [required]
         */
        public function defer ($callback) { }

        /**
         * @param $dst_worker_id [required]
         * @param $data          [required]
         */
        public function sendMessage ($dst_worker_id, $data) { }

        /**
         * @param $process [required]
         */
        public function addProcess ($process) { }

        public function stats () { }

        /**
         * @param $fd  [required]
         * @param $uid [required]
         */
        public function bind ($fd, $uid) { }
    }

    class Response
    {
        public function initHeader () { }

        /**
         * @param $name     [required]
         * @param $value    [optional]
         * @param $expires  [optional]
         * @param $path     [optional]
         * @param $domain   [optional]
         * @param $secure   [optional]
         * @param $httponly [optional]
         */
        public function cookie ($name, $value = NULL, $expires = NULL, $path = NULL, $domain = NULL, $secure = NULL, $httponly = NULL) { }

        /**
         * @param $name     [required]
         * @param $value    [optional]
         * @param $expires  [optional]
         * @param $path     [optional]
         * @param $domain   [optional]
         * @param $secure   [optional]
         * @param $httponly [optional]
         */
        public function rawcookie ($name, $value = NULL, $expires = NULL, $path = NULL, $domain = NULL, $secure = NULL, $httponly = NULL) { }

        /**
         * @param $http_code [required]
         */
        public function status ($http_code) { }

        /**
         * @param $compress_level [optional]
         */
        public function gzip ($compress_level = NULL) { }

        /**
         * @param $key     [required]
         * @param $value   [required]
         * @param $ucwords [optional]
         */
        public function header ($key, $value, $ucwords = NULL) { }

        /**
         * @param $content [required]
         */
        public function write ($content) { }

        /**
         * @param $content [optional]
         */
        public function end ($content = NULL) { }

        /**
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($filename, $offset = NULL, $length = NULL) { }

        public function __destruct () { }
    }

    class Request
    {
        public function rawcontent () { }

        public function __destruct () { }


    }

}

/**
 *@since 1.9.15
 */
namespace Swoole\WebSocket
{
    class Server extends \Swoole\Http\Server
    {
        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }

        /**
         * @param $fd     [required]
         * @param $data   [required]
         * @param $opcode [optional]
         * @param $finish [optional]
         */
        public function push ($fd, $data, $opcode = NULL, $finish = NULL) { }

        /**
         * @param $fd [required]
         */
        public function exist ($fd) { }

        /**
         * @param $data   [required]
         * @param $opcode [optional]
         * @param $finish [optional]
         * @param $mask   [optional]
         */
        public static function pack ($data, $opcode = NULL, $finish = NULL, $mask = NULL) { }

        /**
         * @param $data [required]
         */
        public static function unpack ($data) { }

        public function start () { }

        /**
         * @param $host      [required]
         * @param $port      [optional]
         * @param $mode      [optional]
         * @param $sock_type [optional]
         */
        public function __construct ($host, $port = NULL, $mode = NULL, $sock_type = NULL) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function listen ($host, $port, $sock_type) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function addlistener ($host, $port, $sock_type) { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $fd         [required]
         * @param $send_data  [required]
         * @param $reactor_id [optional]
         */
        public function send ($fd, $send_data, $reactor_id = NULL) { }

        /**
         * @param $ip            [required]
         * @param $port          [required]
         * @param $send_data     [required]
         * @param $server_socket [optional]
         */
        public function sendto ($ip, $port, $send_data, $server_socket = NULL) { }

        /**
         * @param $conn_fd   [required]
         * @param $send_data [required]
         */
        public function sendwait ($conn_fd, $send_data) { }

        /**
         * @param $fd           [required]
         * @param $is_protected [optional]
         */
        public function protect ($fd, $is_protected = NULL) { }

        /**
         * @param $conn_fd  [required]
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($conn_fd, $filename, $offset = NULL, $length = NULL) { }

        /**
         * @param $fd    [required]
         * @param $reset [optional]
         */
        public function close ($fd, $reset = NULL) { }

        /**
         * @param $fd [required]
         */
        public function confirm ($fd) { }

        /**
         * @param $fd [required]
         */
        public function pause ($fd) { }

        /**
         * @param $fd [required]
         */
        public function resume ($fd) { }

        /**
         * @param $data            [required]
         * @param $worker_id       [optional]
         * @param $finish_callback [optional]
         */
        public function task ($data, $worker_id = NULL, $finish_callback = NULL) { }

        /**
         * @param $data      [required]
         * @param $timeout   [optional]
         * @param $worker_id [optional]
         */
        public function taskwait ($data, $timeout = NULL, $worker_id = NULL) { }

        /**
         * @param $tasks   [required]
         * @param $timeout [optional]
         */
        public function taskWaitMulti ($tasks, $timeout = NULL) { }

        /**
         * @param $data [required]
         */
        public function finish ($data) { }

        public function reload () { }

        public function shutdown () { }

        /**
         * @param $worker_id [optional]
         */
        public function stop ($worker_id = NULL) { }

        public function getLastError () { }

        /**
         * @param $reactor_id [required]
         */
        public function heartbeat ($reactor_id) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function connection_info ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function connection_list ($start_fd, $find_count = NULL) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function getClientInfo ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function getClientList ($start_fd, $find_count = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         * @param $param    [optional]
         */
        public function after ($ms, $callback, $param = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         */
        public function tick ($ms, $callback) { }

        /**
         * @param $timer_id [required]
         */
        public function clearTimer ($timer_id) { }

        /**
         * @param $callback [required]
         */
        public function defer ($callback) { }

        /**
         * @param $dst_worker_id [required]
         * @param $data          [required]
         */
        public function sendMessage ($dst_worker_id, $data) { }

        /**
         * @param $process [required]
         */
        public function addProcess ($process) { }

        public function stats () { }

        /**
         * @param $fd  [required]
         * @param $uid [required]
         */
        public function bind ($fd, $uid) { }
    }

    class Frame
    {

    }
}

/**
 *@since 1.9.15
 */
namespace Swoole\MySQL
{
    class Exception extends \Exception
    {
        final private function __clone () { }

        /**
         * @param $message  [optional]
         * @param $code     [optional]
         * @param $previous [optional]
         */
        public function __construct ($message = NULL, $code = NULL, $previous = NULL) { }

        public function __wakeup () { }

        final public function getMessage () { }

        final public function getCode () { }

        final public function getFile () { }

        final public function getLine () { }

        final public function getTrace () { }

        final public function getPrevious () { }

        final public function getTraceAsString () { }

        public function __toString () { }
    }
}

/**
 *@since 1.9.15
 */
namespace Swoole\Redis
{
    class Server extends \Swoole\Server
    {
        public function start () { }

        /**
         * @param $command                [required]
         * @param $callback               [required]
         * @param $number_of_string_param [optional]
         * @param $type_of_array_param    [optional]
         */
        public function setHandler ($command, $callback, $number_of_string_param = NULL, $type_of_array_param = NULL) { }

        /**
         * @param $type  [required]
         * @param $value [optional]
         */
        public static function format ($type, $value = NULL) { }

        /**
         * @param $host      [required]
         * @param $port      [optional]
         * @param $mode      [optional]
         * @param $sock_type [optional]
         */
        public function __construct ($host, $port = NULL, $mode = NULL, $sock_type = NULL) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function listen ($host, $port, $sock_type) { }

        /**
         * @param $host      [required]
         * @param $port      [required]
         * @param $sock_type [required]
         */
        public function addlistener ($host, $port, $sock_type) { }

        /**
         * @param $event_name [required]
         * @param $callback   [required]
         */
        public function on ($event_name, $callback) { }

        /**
         * @param $settings [required]
         */
        public function set ($settings) { }

        /**
         * @param $fd         [required]
         * @param $send_data  [required]
         * @param $reactor_id [optional]
         */
        public function send ($fd, $send_data, $reactor_id = NULL) { }

        /**
         * @param $ip            [required]
         * @param $port          [required]
         * @param $send_data     [required]
         * @param $server_socket [optional]
         */
        public function sendto ($ip, $port, $send_data, $server_socket = NULL) { }

        /**
         * @param $conn_fd   [required]
         * @param $send_data [required]
         */
        public function sendwait ($conn_fd, $send_data) { }

        /**
         * @param $fd [required]
         */
        public function exist ($fd) { }

        /**
         * @param $fd           [required]
         * @param $is_protected [optional]
         */
        public function protect ($fd, $is_protected = NULL) { }

        /**
         * @param $conn_fd  [required]
         * @param $filename [required]
         * @param $offset   [optional]
         * @param $length   [optional]
         */
        public function sendfile ($conn_fd, $filename, $offset = NULL, $length = NULL) { }

        /**
         * @param $fd    [required]
         * @param $reset [optional]
         */
        public function close ($fd, $reset = NULL) { }

        /**
         * @param $fd [required]
         */
        public function confirm ($fd) { }

        /**
         * @param $fd [required]
         */
        public function pause ($fd) { }

        /**
         * @param $fd [required]
         */
        public function resume ($fd) { }

        /**
         * @param $data            [required]
         * @param $worker_id       [optional]
         * @param $finish_callback [optional]
         */
        public function task ($data, $worker_id = NULL, $finish_callback = NULL) { }

        /**
         * @param $data      [required]
         * @param $timeout   [optional]
         * @param $worker_id [optional]
         */
        public function taskwait ($data, $timeout = NULL, $worker_id = NULL) { }

        /**
         * @param $tasks   [required]
         * @param $timeout [optional]
         */
        public function taskWaitMulti ($tasks, $timeout = NULL) { }

        /**
         * @param $data [required]
         */
        public function finish ($data) { }

        public function reload () { }

        public function shutdown () { }

        /**
         * @param $worker_id [optional]
         */
        public function stop ($worker_id = NULL) { }

        public function getLastError () { }

        /**
         * @param $reactor_id [required]
         */
        public function heartbeat ($reactor_id) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function connection_info ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function connection_list ($start_fd, $find_count = NULL) { }

        /**
         * @param $fd         [required]
         * @param $reactor_id [optional]
         */
        public function getClientInfo ($fd, $reactor_id = NULL) { }

        /**
         * @param $start_fd   [required]
         * @param $find_count [optional]
         */
        public function getClientList ($start_fd, $find_count = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         * @param $param    [optional]
         */
        public function after ($ms, $callback, $param = NULL) { }

        /**
         * @param $ms       [required]
         * @param $callback [required]
         */
        public function tick ($ms, $callback) { }

        /**
         * @param $timer_id [required]
         */
        public function clearTimer ($timer_id) { }

        /**
         * @param $callback [required]
         */
        public function defer ($callback) { }

        /**
         * @param $dst_worker_id [required]
         * @param $data          [required]
         */
        public function sendMessage ($dst_worker_id, $data) { }

        /**
         * @param $process [required]
         */
        public function addProcess ($process) { }

        public function stats () { }

        /**
         * @param $fd  [required]
         * @param $uid [required]
         */
        public function bind ($fd, $uid) { }


    }
}

/**
 *@since 1.9.15
 */
class swoole_server{
    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $mode[optional]
     * @param $sock_type[optional]
     */
    public function __construct($host,$port=null,$mode=null,$sock_type=null){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function listen($host,$port,$sock_type){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function addlistener($host,$port,$sock_type){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    public function start(){}

    /**
     * @param $fd[required]
     * @param $send_data[required]
     * @param $reactor_id[optional]
     */
    public function send($fd,$send_data,$reactor_id=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $send_data[required]
     * @param $server_socket[optional]
     */
    public function sendto($ip,$port,$send_data,$server_socket=null){}

    /**
     * @param $conn_fd[required]
     * @param $send_data[required]
     */
    public function sendwait($conn_fd,$send_data){}

    /**
     * @param $fd[required]
     */
    public function exist($fd){}

    /**
     * @param $fd[required]
     * @param $is_protected[optional]
     */
    public function protect($fd,$is_protected=null){}

    /**
     * @param $conn_fd[required]
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($conn_fd,$filename,$offset=null,$length=null){}

    /**
     * @param $fd[required]
     * @param $reset[optional]
     */
    public function close($fd,$reset=null){}

    /**
     * @param $fd[required]
     */
    public function confirm($fd){}

    /**
     * @param $fd[required]
     */
    public function pause($fd){}

    /**
     * @param $fd[required]
     */
    public function resume($fd){}

    /**
     * @param $data[required]
     * @param $worker_id[optional]
     * @param $finish_callback[optional]
     */
    public function task($data,$worker_id=null,$finish_callback=null){}

    /**
     * @param $data[required]
     * @param $timeout[optional]
     * @param $worker_id[optional]
     */
    public function taskwait($data,$timeout=null,$worker_id=null){}

    /**
     * @param $tasks[required]
     * @param $timeout[optional]
     */
    public function taskWaitMulti($tasks,$timeout=null){}

    /**
     * @param $data[required]
     */
    public function finish($data){}

    public function reload(){}

    public function shutdown(){}

    /**
     * @param $worker_id[optional]
     */
    public function stop($worker_id=null){}

    public function getLastError(){}

    /**
     * @param $reactor_id[required]
     */
    public function heartbeat($reactor_id){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function connection_info($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function connection_list($start_fd,$find_count=null){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function getClientInfo($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function getClientList($start_fd,$find_count=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     * @param $param[optional]
     */
    public function after($ms,$callback,$param=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     */
    public function tick($ms,$callback){}

    /**
     * @param $timer_id[required]
     */
    public function clearTimer($timer_id){}

    /**
     * @param $callback[required]
     */
    public function defer($callback){}

    /**
     * @param $dst_worker_id[required]
     * @param $data[required]
     */
    public function sendMessage($dst_worker_id,$data){}

    /**
     * @param $process[required]
     */
    public function addProcess($process){}

    public function stats(){}

    /**
     * @param $fd[required]
     * @param $uid[required]
     */
    public function bind($fd,$uid){}


}
/**
 *@since 1.9.15
 */
class swoole_timer{
    /**
     * @param $ms[required]
     * @param $callback[required]
     * @param $param[optional]
     */
    public static function tick($ms,$callback,$param=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     */
    public static function after($ms,$callback){}

    /**
     * @param $timer_id[required]
     */
    public static function exists($timer_id){}

    /**
     * @param $timer_id[required]
     */
    public static function clear($timer_id){}


}
/**
 *@since 1.9.15
 */
class swoole_event{
    /**
     * @param $fd[required]
     * @param $read_callback[required]
     * @param $write_callback[optional]
     * @param $events[optional]
     */
    public static function add($fd,$read_callback,$write_callback=null,$events=null){}

    /**
     * @param $fd[required]
     */
    public static function del($fd){}

    /**
     * @param $fd[required]
     * @param $read_callback[optional]
     * @param $write_callback[optional]
     * @param $events[optional]
     */
    public static function set($fd,$read_callback=null,$write_callback=null,$events=null){}

    public static function exit(){}

    /**
     * @param $fd[required]
     * @param $data[required]
     */
    public static function write($fd,$data){}

    public static function wait(){}

    /**
     * @param $callback[required]
     */
    public static function defer($callback){}


}
/**
 *@since 1.9.15
 */
class swoole_async{
    /**
     * @param $filename[required]
     * @param $callback[required]
     * @param $chunk_size[optional]
     * @param $offset[optional]
     */
    public static function read($filename,$callback,$chunk_size=null,$offset=null){}

    /**
     * @param $filename[required]
     * @param $content[required]
     * @param $offset[optional]
     * @param $callback[optional]
     */
    public static function write($filename,$content,$offset=null,$callback=null){}

    /**
     * @param $filename[required]
     * @param $callback[required]
     */
    public static function readFile($filename,$callback){}

    /**
     * @param $filename[required]
     * @param $content[required]
     * @param $callback[optional]
     * @param $flags[optional]
     */
    public static function writeFile($filename,$content,$callback=null,$flags=null){}

    /**
     * @param $domain_name[required]
     * @param $content[required]
     */
    public static function dnsLookup($domain_name,$content){}

    /**
     * @param $settings[required]
     */
    public static function set($settings){}


}
/**
 *@since 1.9.15
 */
class swoole_connection_iterator{
    public function rewind(){}

    public function next(){}

    public function current(){}

    public function key(){}

    public function valid(){}

    public function count(){}

    /**
     * @param $fd[required]
     */
    public function offsetExists($fd){}

    /**
     * @param $fd[required]
     */
    public function offsetGet($fd){}

    /**
     * @param $fd[required]
     * @param $value[required]
     */
    public function offsetSet($fd,$value){}

    /**
     * @param $fd[required]
     */
    public function offsetUnset($fd){}


}
/**
 *@since 1.9.15
 */
class swoole_exception extends Exception{
    final private function __clone(){}

    /**
     * @param $message[optional]
     * @param $code[optional]
     * @param $previous[optional]
     */
    public function __construct($message=null,$code=null,$previous=null){}

    public function __wakeup(){}

    final public function getMessage(){}

    final public function getCode(){}

    final public function getFile(){}

    final public function getLine(){}

    final public function getTrace(){}

    final public function getPrevious(){}

    final public function getTraceAsString(){}

    public function __toString(){}


}

/**
 *@since 1.9.15
 */
class swoole_server_port{
    private function __construct(){}

    public function __destruct(){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}


}
/**
 *@since 1.9.15
 */
class swoole_client{
    /**
     * @param $type[required]
     * @param $async[optional]
     */
    public function __construct($type,$async=null){}

    public function __destruct(){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $timeout[optional]
     * @param $sock_flag[optional]
     */
    public function connect($host,$port=null,$timeout=null,$sock_flag=null){}

    /**
     * @param $size[optional]
     * @param $flag[optional]
     */
    public function recv($size=null,$flag=null){}

    /**
     * @param $data[required]
     * @param $flag[optional]
     */
    public function send($data,$flag=null){}

    /**
     * @param $dst_socket[required]
     */
    public function pipe($dst_socket){}

    /**
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($filename,$offset=null,$length=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $data[required]
     */
    public function sendto($ip,$port,$data){}

    public function sleep(){}

    public function wakeup(){}

    public function pause(){}

    public function resume(){}

    /**
     * @param $callback[optional]
     */
    public function enableSSL($callback=null){}

    public function getPeerCert(){}

    public function verifyPeerCert(){}

    public function isConnected(){}

    public function getsockname(){}

    public function getpeername(){}

    /**
     * @param $force[optional]
     */
    public function close($force=null){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}


}
/**
 *@since 1.9.15
 */
class swoole_http_client{
    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $ssl[optional]
     */
    public function __construct($host,$port=null,$ssl=null){}

    public function __destruct(){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $method[required]
     */
    public function setMethod($method){}

    /**
     * @param $headers[required]
     */
    public function setHeaders($headers){}

    /**
     * @param $cookies[required]
     */
    public function setCookies($cookies){}

    /**
     * @param $data[required]
     */
    public function setData($data){}

    /**
     * @param $path[required]
     * @param $name[required]
     * @param $type[optional]
     * @param $filename[optional]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function addFile($path,$name,$type=null,$filename=null,$offset=null,$length=null){}

    /**
     * @param $path[required]
     * @param $callback[required]
     */
    public function execute($path,$callback){}

    /**
     * @param $data[required]
     * @param $opcode[optional]
     * @param $finish[optional]
     */
    public function push($data,$opcode=null,$finish=null){}

    /**
     * @param $path[required]
     * @param $callback[required]
     */
    public function get($path,$callback){}

    /**
     * @param $path[required]
     * @param $data[required]
     * @param $callback[required]
     */
    public function post($path,$data,$callback){}

    /**
     * @param $path[required]
     * @param $callback[required]
     */
    public function upgrade($path,$callback){}

    /**
     * @param $path[required]
     * @param $file[required]
     * @param $callback[required]
     * @param $offset[optional]
     */
    public function download($path,$file,$callback,$offset=null){}

    public function isConnected(){}

    public function close(){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}


}
/**
 *@since 1.9.15
 */
class swoole_process{
    /**
     * @param $callback[required]
     * @param $redirect_stdin_and_stdout[optional]
     * @param $pipe_type[optional]
     */
    public function __construct($callback,$redirect_stdin_and_stdout=null,$pipe_type=null){}

    public function __destruct(){}

    /**
     * @param $blocking[optional]
     */
    public static function wait($blocking=null){}

    /**
     * @param $signal_no[required]
     * @param $callback[required]
     */
    public static function signal($signal_no,$callback){}

    /**
     * @param $usec[required]
     */
    public static function alarm($usec){}

    /**
     * @param $pid[required]
     * @param $signal_no[optional]
     */
    public static function kill($pid,$signal_no=null){}

    /**
     * @param $nochdir[optional]
     * @param $noclose[optional]
     */
    public static function daemon($nochdir=null,$noclose=null){}

    /**
     * @param $cpu_settings[required]
     */
    public static function setaffinity($cpu_settings){}

    /**
     * @param $key[required]
     * @param $mode[optional]
     */
    public function useQueue($key,$mode=null){}

    public function statQueue(){}

    public function freeQueue(){}

    public function start(){}

    /**
     * @param $data[required]
     */
    public function write($data){}

    public function close(){}

    /**
     * @param $size[optional]
     */
    public function read($size=null){}

    /**
     * @param $data[required]
     */
    public function push($data){}

    /**
     * @param $size[optional]
     */
    public function pop($size=null){}

    /**
     * @param $exit_code[optional]
     */
    public function exit($exit_code=null){}

    /**
     * @param $exec_file[required]
     * @param $args[required]
     */
    public function exec($exec_file,$args){}

    /**
     * @param $process_name[required]
     */
    public function name($process_name){}


}
/**
 *@since 1.9.15
 */
class swoole_table{
    /**
     * @param $table_size[required]
     */
    public function __construct($table_size){}

    /**
     * @param $name[required]
     * @param $type[required]
     * @param $size[optional]
     */
    public function column($name,$type,$size=null){}

    public function create(){}

    public function destroy(){}

    /**
     * @param $key[required]
     * @param $value[required]
     */
    public function set($key,$value){}

    /**
     * @param $key[required]
     * @param $field[optional]
     */
    public function get($key,$field=null){}

    public function count(){}

    /**
     * @param $key[required]
     */
    public function del($key){}

    /**
     * @param $key[required]
     * @param $field[optional]
     */
    public function exist($key,$field=null){}

    /**
     * @param $key[required]
     * @param $column[required]
     * @param $incrby[optional]
     */
    public function incr($key,$column,$incrby=null){}

    /**
     * @param $key[required]
     * @param $column[required]
     * @param $decrby[optional]
     */
    public function decr($key,$column,$decrby=null){}

    public function rewind(){}

    public function next(){}

    public function current(){}

    public function key(){}

    public function valid(){}


}
/**
 *@since 1.9.15
 */
class swoole_lock{
    /**
     * @param $type[optional]
     * @param $filename[optional]
     */
    public function __construct($type=null,$filename=null){}

    public function __destruct(){}

    public function lock(){}

    public function trylock(){}

    public function lock_read(){}

    public function trylock_read(){}

    public function unlock(){}


}
/**
 *@since 1.9.15
 */
class swoole_atomic{
    /**
     * @param $value[optional]
     */
    public function __construct($value=null){}

    /**
     * @param $add_value[optional]
     */
    public function add($add_value=null){}

    /**
     * @param $sub_value[optional]
     */
    public function sub($sub_value=null){}

    public function get(){}

    /**
     * @param $value[required]
     */
    public function set($value){}

    /**
     * @param $timeout[optional]
     */
    public function wait($timeout=null){}

    /**
     * @param $count[optional]
     */
    public function wakeup($count=null){}

    /**
     * @param $cmp_value[required]
     * @param $new_value[required]
     */
    public function cmpset($cmp_value,$new_value){}


}
/**
 *@since 1.9.15
 */
class swoole_http_server extends Swoole\Server{
    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}

    public function start(){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $mode[optional]
     * @param $sock_type[optional]
     */
    public function __construct($host,$port=null,$mode=null,$sock_type=null){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function listen($host,$port,$sock_type){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function addlistener($host,$port,$sock_type){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $fd[required]
     * @param $send_data[required]
     * @param $reactor_id[optional]
     */
    public function send($fd,$send_data,$reactor_id=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $send_data[required]
     * @param $server_socket[optional]
     */
    public function sendto($ip,$port,$send_data,$server_socket=null){}

    /**
     * @param $conn_fd[required]
     * @param $send_data[required]
     */
    public function sendwait($conn_fd,$send_data){}

    /**
     * @param $fd[required]
     */
    public function exist($fd){}

    /**
     * @param $fd[required]
     * @param $is_protected[optional]
     */
    public function protect($fd,$is_protected=null){}

    /**
     * @param $conn_fd[required]
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($conn_fd,$filename,$offset=null,$length=null){}

    /**
     * @param $fd[required]
     * @param $reset[optional]
     */
    public function close($fd,$reset=null){}

    /**
     * @param $fd[required]
     */
    public function confirm($fd){}

    /**
     * @param $fd[required]
     */
    public function pause($fd){}

    /**
     * @param $fd[required]
     */
    public function resume($fd){}

    /**
     * @param $data[required]
     * @param $worker_id[optional]
     * @param $finish_callback[optional]
     */
    public function task($data,$worker_id=null,$finish_callback=null){}

    /**
     * @param $data[required]
     * @param $timeout[optional]
     * @param $worker_id[optional]
     */
    public function taskwait($data,$timeout=null,$worker_id=null){}

    /**
     * @param $tasks[required]
     * @param $timeout[optional]
     */
    public function taskWaitMulti($tasks,$timeout=null){}

    /**
     * @param $data[required]
     */
    public function finish($data){}

    public function reload(){}

    public function shutdown(){}

    /**
     * @param $worker_id[optional]
     */
    public function stop($worker_id=null){}

    public function getLastError(){}

    /**
     * @param $reactor_id[required]
     */
    public function heartbeat($reactor_id){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function connection_info($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function connection_list($start_fd,$find_count=null){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function getClientInfo($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function getClientList($start_fd,$find_count=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     * @param $param[optional]
     */
    public function after($ms,$callback,$param=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     */
    public function tick($ms,$callback){}

    /**
     * @param $timer_id[required]
     */
    public function clearTimer($timer_id){}

    /**
     * @param $callback[required]
     */
    public function defer($callback){}

    /**
     * @param $dst_worker_id[required]
     * @param $data[required]
     */
    public function sendMessage($dst_worker_id,$data){}

    /**
     * @param $process[required]
     */
    public function addProcess($process){}

    public function stats(){}

    /**
     * @param $fd[required]
     * @param $uid[required]
     */
    public function bind($fd,$uid){}


}
/**
 *@since 1.9.15
 */
class swoole_http_response{
    public function initHeader(){}

    /**
     * @param $name[required]
     * @param $value[optional]
     * @param $expires[optional]
     * @param $path[optional]
     * @param $domain[optional]
     * @param $secure[optional]
     * @param $httponly[optional]
     */
    public function cookie($name,$value=null,$expires=null,$path=null,$domain=null,$secure=null,$httponly=null){}

    /**
     * @param $name[required]
     * @param $value[optional]
     * @param $expires[optional]
     * @param $path[optional]
     * @param $domain[optional]
     * @param $secure[optional]
     * @param $httponly[optional]
     */
    public function rawcookie($name,$value=null,$expires=null,$path=null,$domain=null,$secure=null,$httponly=null){}

    /**
     * @param $http_code[required]
     */
    public function status($http_code){}

    /**
     * @param $compress_level[optional]
     */
    public function gzip($compress_level=null){}

    /**
     * @param $key[required]
     * @param $value[required]
     * @param $ucwords[optional]
     */
    public function header($key,$value,$ucwords=null){}

    /**
     * @param $content[required]
     */
    public function write($content){}

    /**
     * @param $content[optional]
     */
    public function end($content=null){}

    /**
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($filename,$offset=null,$length=null){}

    public function __destruct(){}


}
/**
 *@since 1.9.15
 */
class swoole_http_request{
    public function rawcontent(){}

    public function __destruct(){}


}
/**
 *@since 1.9.15
 */
class swoole_buffer{
    /**
     * @param $size[optional]
     */
    public function __construct($size=null){}

    public function __destruct(){}

    public function __toString(){}

    /**
     * @param $offset[required]
     * @param $length[optional]
     * @param $seek[optional]
     */
    public function substr($offset,$length=null,$seek=null){}

    /**
     * @param $offset[required]
     * @param $data[required]
     */
    public function write($offset,$data){}

    /**
     * @param $offset[required]
     * @param $length[required]
     */
    public function read($offset,$length){}

    /**
     * @param $data[required]
     */
    public function append($data){}

    /**
     * @param $size[required]
     */
    public function expand($size){}

    public function recycle(){}

    public function clear(){}


}
/**
 *@since 1.9.15
 */
class swoole_websocket_server extends Swoole\Http\Server{
    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}

    /**
     * @param $fd[required]
     * @param $data[required]
     * @param $opcode[optional]
     * @param $finish[optional]
     */
    public function push($fd,$data,$opcode=null,$finish=null){}

    /**
     * @param $fd[required]
     */
    public function exist($fd){}

    /**
     * @param $data[required]
     * @param $opcode[optional]
     * @param $finish[optional]
     * @param $mask[optional]
     */
    public static function pack($data,$opcode=null,$finish=null,$mask=null){}

    /**
     * @param $data[required]
     */
    public static function unpack($data){}

    public function start(){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $mode[optional]
     * @param $sock_type[optional]
     */
    public function __construct($host,$port=null,$mode=null,$sock_type=null){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function listen($host,$port,$sock_type){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function addlistener($host,$port,$sock_type){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $fd[required]
     * @param $send_data[required]
     * @param $reactor_id[optional]
     */
    public function send($fd,$send_data,$reactor_id=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $send_data[required]
     * @param $server_socket[optional]
     */
    public function sendto($ip,$port,$send_data,$server_socket=null){}

    /**
     * @param $conn_fd[required]
     * @param $send_data[required]
     */
    public function sendwait($conn_fd,$send_data){}

    /**
     * @param $fd[required]
     * @param $is_protected[optional]
     */
    public function protect($fd,$is_protected=null){}

    /**
     * @param $conn_fd[required]
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($conn_fd,$filename,$offset=null,$length=null){}

    /**
     * @param $fd[required]
     * @param $reset[optional]
     */
    public function close($fd,$reset=null){}

    /**
     * @param $fd[required]
     */
    public function confirm($fd){}

    /**
     * @param $fd[required]
     */
    public function pause($fd){}

    /**
     * @param $fd[required]
     */
    public function resume($fd){}

    /**
     * @param $data[required]
     * @param $worker_id[optional]
     * @param $finish_callback[optional]
     */
    public function task($data,$worker_id=null,$finish_callback=null){}

    /**
     * @param $data[required]
     * @param $timeout[optional]
     * @param $worker_id[optional]
     */
    public function taskwait($data,$timeout=null,$worker_id=null){}

    /**
     * @param $tasks[required]
     * @param $timeout[optional]
     */
    public function taskWaitMulti($tasks,$timeout=null){}

    /**
     * @param $data[required]
     */
    public function finish($data){}

    public function reload(){}

    public function shutdown(){}

    /**
     * @param $worker_id[optional]
     */
    public function stop($worker_id=null){}

    public function getLastError(){}

    /**
     * @param $reactor_id[required]
     */
    public function heartbeat($reactor_id){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function connection_info($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function connection_list($start_fd,$find_count=null){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function getClientInfo($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function getClientList($start_fd,$find_count=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     * @param $param[optional]
     */
    public function after($ms,$callback,$param=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     */
    public function tick($ms,$callback){}

    /**
     * @param $timer_id[required]
     */
    public function clearTimer($timer_id){}

    /**
     * @param $callback[required]
     */
    public function defer($callback){}

    /**
     * @param $dst_worker_id[required]
     * @param $data[required]
     */
    public function sendMessage($dst_worker_id,$data){}

    /**
     * @param $process[required]
     */
    public function addProcess($process){}

    public function stats(){}

    /**
     * @param $fd[required]
     * @param $uid[required]
     */
    public function bind($fd,$uid){}


}
/**
 *@since 1.9.15
 */
class swoole_websocket_frame{

}
/**
 *@since 1.9.15
 */
class swoole_mysql{
    public function __construct(){}

    public function __destruct(){}

    /**
     * @param $server_config[required]
     * @param $callback[required]
     */
    public function connect($server_config,$callback){}

    /**
     * @param $callback[required]
     */
    public function begin($callback){}

    /**
     * @param $callback[required]
     */
    public function commit($callback){}

    /**
     * @param $callback[required]
     */
    public function rollback($callback){}

    /**
     * @param $sql[required]
     * @param $callback[required]
     */
    public function query($sql,$callback){}

    public function close(){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}


}
/**
 *@since 1.9.15
 */
class swoole_mysql_exception extends Exception{
    final private function __clone(){}

    /**
     * @param $message[optional]
     * @param $code[optional]
     * @param $previous[optional]
     */
    public function __construct($message=null,$code=null,$previous=null){}

    public function __wakeup(){}

    final public function getMessage(){}

    final public function getCode(){}

    final public function getFile(){}

    final public function getLine(){}

    final public function getTrace(){}

    final public function getPrevious(){}

    final public function getTraceAsString(){}

    public function __toString(){}


}
/**
 *@since 1.9.15
 */
class swoole_mmap{
    /**
     * @param $filename[required]
     * @param $size[optional]
     * @param $offset[optional]
     */
    public static function open($filename,$size=null,$offset=null){}


}
/**
 *@since 1.9.15
 */
class swoole_channel{
    /**
     * @param $size[required]
     */
    public function __construct($size){}

    public function __destruct(){}

    /**
     * @param $data[required]
     */
    public function push($data){}

    public function pop(){}

    public function stats(){}


}
/**
 *@since 1.9.15
 */
class swoole_serialize{
    /**
     * @param $data[required]
     * @param $flag[optional]
     */
    public static function pack($data,$flag=null){}

    /**
     * @param $string[required]
     * @param $args[optional]
     */
    public static function unpack($string,$args=null){}


}
/**
 *@since 1.9.15
 */
class swoole_redis{
    public function __construct(){}

    public function __destruct(){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $callback[required]
     */
    public function connect($host,$port,$callback){}

    public function close(){}

    /**
     * @param $command[required]
     * @param $params[required]
     */
    public function __call($command,$params){}


}
/**
 *@since 1.9.15
 */
class swoole_redis_server extends Swoole\Server{
    public function start(){}

    /**
     * @param $command[required]
     * @param $callback[required]
     * @param $number_of_string_param[optional]
     * @param $type_of_array_param[optional]
     */
    public function setHandler($command,$callback,$number_of_string_param=null,$type_of_array_param=null){}

    /**
     * @param $type[required]
     * @param $value[optional]
     */
    public static function format($type,$value=null){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $mode[optional]
     * @param $sock_type[optional]
     */
    public function __construct($host,$port=null,$mode=null,$sock_type=null){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function listen($host,$port,$sock_type){}

    /**
     * @param $host[required]
     * @param $port[required]
     * @param $sock_type[required]
     */
    public function addlistener($host,$port,$sock_type){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     */
    public function on($event_name,$callback){}

    /**
     * @param $settings[required]
     */
    public function set($settings){}

    /**
     * @param $fd[required]
     * @param $send_data[required]
     * @param $reactor_id[optional]
     */
    public function send($fd,$send_data,$reactor_id=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $send_data[required]
     * @param $server_socket[optional]
     */
    public function sendto($ip,$port,$send_data,$server_socket=null){}

    /**
     * @param $conn_fd[required]
     * @param $send_data[required]
     */
    public function sendwait($conn_fd,$send_data){}

    /**
     * @param $fd[required]
     */
    public function exist($fd){}

    /**
     * @param $fd[required]
     * @param $is_protected[optional]
     */
    public function protect($fd,$is_protected=null){}

    /**
     * @param $conn_fd[required]
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     */
    public function sendfile($conn_fd,$filename,$offset=null,$length=null){}

    /**
     * @param $fd[required]
     * @param $reset[optional]
     */
    public function close($fd,$reset=null){}

    /**
     * @param $fd[required]
     */
    public function confirm($fd){}

    /**
     * @param $fd[required]
     */
    public function pause($fd){}

    /**
     * @param $fd[required]
     */
    public function resume($fd){}

    /**
     * @param $data[required]
     * @param $worker_id[optional]
     * @param $finish_callback[optional]
     */
    public function task($data,$worker_id=null,$finish_callback=null){}

    /**
     * @param $data[required]
     * @param $timeout[optional]
     * @param $worker_id[optional]
     */
    public function taskwait($data,$timeout=null,$worker_id=null){}

    /**
     * @param $tasks[required]
     * @param $timeout[optional]
     */
    public function taskWaitMulti($tasks,$timeout=null){}

    /**
     * @param $data[required]
     */
    public function finish($data){}

    public function reload(){}

    public function shutdown(){}

    /**
     * @param $worker_id[optional]
     */
    public function stop($worker_id=null){}

    public function getLastError(){}

    /**
     * @param $reactor_id[required]
     */
    public function heartbeat($reactor_id){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function connection_info($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function connection_list($start_fd,$find_count=null){}

    /**
     * @param $fd[required]
     * @param $reactor_id[optional]
     */
    public function getClientInfo($fd,$reactor_id=null){}

    /**
     * @param $start_fd[required]
     * @param $find_count[optional]
     */
    public function getClientList($start_fd,$find_count=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     * @param $param[optional]
     */
    public function after($ms,$callback,$param=null){}

    /**
     * @param $ms[required]
     * @param $callback[required]
     */
    public function tick($ms,$callback){}

    /**
     * @param $timer_id[required]
     */
    public function clearTimer($timer_id){}

    /**
     * @param $callback[required]
     */
    public function defer($callback){}

    /**
     * @param $dst_worker_id[required]
     * @param $data[required]
     */
    public function sendMessage($dst_worker_id,$data){}

    /**
     * @param $process[required]
     */
    public function addProcess($process){}

    public function stats(){}

    /**
     * @param $fd[required]
     * @param $uid[required]
     */
    public function bind($fd,$uid){}


}