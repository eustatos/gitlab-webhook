<?php
    namespace Eustatos\gitlab\webhook;

    /**
     * Event
     *
     * @package Eustatos\gitlab\webhook
     * @author  Alexander Astashkin <astashkinav@gmail.com>
     */
class Event
{
    private $_command;
    private $_output = [];
    private $_result;
    private $_server;
    const TOKEN = 'b2b pushed';

    /**
     * __construct
     *
     * @param string $command
     * @param  string $password
     * $param array $server
     * @access public
     */
    public function __construct($command, $password, $server)
    {
        $this->_command = $command;
        $this->_server = $server;

        if ($password == self::TOKEN) {
            exec(
                $this->_command,
                $this->_output,
                $this->_result
            );
        }
    }

    /**
     * getResult
     *
     * @access public
     * @return void
     */
    public function getResult()
    {
        echo 'Result execution: ' . $this->_command . PHP_EOL
        . $this->_result . PHP_EOL;
        echo '<pre>';
            foreach($this->_ouput as $outputString) {
                echo $outputString . '<br>';
            }
        echo '</pre>';
    }

    /**
     * logResult
     *
     * @param  string $file
     * @access public
     * @return void
     */
    public function logResult($file)
    {
        $this->writeToFile(
            $file,
            $this->_output
        );
    }

    /**
     * logRequest
     *
     * @param  string $file
     * @access public
     * @return void
     */
    public function logRequest($file)
    {
        if (strcasecmp($this->_server['REQUEST_METHOD'], 'POST') != 0) {
            throw new \Exception('Request method must be POST!');
        }
        $contentType = isset($this->_server['CONTENT_TYPE'])
            ? trim($this->_server['CONTENT_TYPE'])
            : '';
        if (strcasecmp($contentType, 'application/json') != 0) {
            throw new \Exception('Content type must be: application/json');
        }
        $jsonRequest = trim(file_get_contents('php://input'));
        $jsonRequest = json_decode($jsonRequest, true);
        if (!is_array($jsonRequest)) {
            throw new \Exception('Received content conteined invalid JSON');
        }
        $this->writeToFile(
            $file,
            $jsonRequest
        );
    }

    /**
     * writeToFile
     *
     * Write to file
     *
     * @param string $file    relative path to file for write the content
     *                        Example: `bashexec.log`
     *
     * @param  mixed  $content String or array
     * @access public
     * @return void
     */
    public function writeToFile($file, $content)
    {
        file_put_contents(
            __DIR__ . DIRECTORY_SEPARATOR . $file,
            '--------------' . date('Y-m-d H:m:s') . '------------' . PHP_EOL
            . print_r($content, true),
            FILE_APPEND | LOCK_EX
        );
    }
}
