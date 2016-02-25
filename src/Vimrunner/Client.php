<?php

namespace Vimrunner;

use \Vimrunner\EscCodes as C;

class Client {

    protected $binaryName = 'vim';

    public function __construct($server, $binaryName = 'vim'){
        $this->server = $server;
        $this->binaryName = $binaryName;
    }

    public function write($string, $keyDelay=0) {
        $bracketComm = "";
        foreach (str_split($string) as $s){
            if ($s == "<" || $bracketComm != ""){
                $bracketComm .= $s;
            }
            if ($bracketComm != "" && $s == ">"){
                $this->remoteSend($bracketComm);
                $bracketComm = "";
                usleep($keyDelay * 100000);
            } elseif ($bracketComm == "") {
                $s = addslashes($s);
                $this->remoteSend($s);
                usleep($keyDelay * 100000);
            }
        }
    }

    public function writeLine($str, $delay=0, $insertModeCommand="i"){
        $this->write($insertModeCommand.$str."\n".C::ESC, $delay);
    }

    public function deleteLine($line=false){
        $this->ensureInNormalMode();
        $this->remoteSend('"_dd');
    }

    public function clearBuffer() {
        $this->ensureInNormalMode();
        $this->remoteSend('gg"_dG', 0);
    }


    public function insert($string) {
        $this->write("a".$str."\n".C::ESC, $delay);
    }

    public function normal($command) {
        $this->ensureInNormalMode();
        $this->remoteSend($command);
    }

    public function command($command) {
        $this->ensureInNormalMode();
        $this->remoteSend(":".$command.C::CR);
    }

    public function remoteSend($c){
        exec($this->binaryName.' --servername '.$this->server.' vimrunner-php --remote-send "'.addslashes($c).'"');
    }

    public function remoteExpr($c){
        exec($this->binaryName.' --servername '.$this->server.' vimrunner-php --remote-expr "'.addslashes($c).'"');
    }

    public function ensureInNormalMode(){
        $this->remoteSend("<c-\\><c-n>");
    }


    public function editFile($path) {
        $this->command("edit ".$path);
    }
}
