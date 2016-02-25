<?php

require 'vendor/autoload.php';

$c = new Vimrunner\Client("foo");
$c->editFile("/tmp/bar.md");
$c->writeLine("Woo This Works", 1);
$c->writeLine("Again", 1);

$c->remoteSend("IHelloWorld<esc>", 2);
sleep(2);

$c->remoteSend("k");
sleep(2);

$c->deleteLine();
sleep(2);

$c->remoteSend("IHello\n");
sleep(3);
$c->clearBuffer();

$c->writeLine("Saying goodbye in 3...", 2);
sleep(1);
$c->writeLine("2...", 2);
sleep(1);
$c->writeLine("1...", 2);
sleep(1);
$c->writeLine("Goodbye!", 2);
sleep(3);
$c->command("q!");
