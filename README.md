# vimrunner-php

This is a hugely untested library for sending commands to a remote Vim instance. For an example of how to use it, look at [example.php](example.php)

### Creating a client

Make sure that your `vim` is compiled with `+clientserver` with `vim --version | grep clientserver`. If it starts with a + it supports it. If it starts with a - it doesn't. `gvim` and `macvim` tend to come with it enabled.

Start vim with `vim --servername FOO` to start it with the remote server enabled.

In your script, create a new client like so:

```php
$c = new Vimrunner\Client("FOO");
```

All of the available commands so far are in `src/Vimrunner/Client.php`.

### Available commands

The most common command will be `writeLine`.

```
// Will type "Hello World", with 0.1 seconds between each key press
// and add a new line "\n" at the end
$c->writeLine("Hello World", 1);

// You can also decide how you enter insert mode
// e.g. enter in append mode
$c->writeLine("Hello World", 1, "a");
```

`writeLine` will put you in normal mode once they're done typing.

Other useful methods:

```
// Make sure we're in normal mode
$c->ensureInNormalMode();

// Send a string of key presses in normal mode
// e.g. Reformat the entire file
$c->normal("gg=G");

// Send a command
// e.g. :w
$c->command("w");

// Open a file for editing
$c->editFile("/tmp/example");
```




