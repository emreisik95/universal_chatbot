<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Stream_set
$config = [
    // Your driver-specific configuration
     "telegram" => [
        "token" => "1379397122:AAHqkPEsBdxUOLdutwxMS82O2t5ZbXv-POk"
     ]
];

// Load the driver(s) you want to use
DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

class OnboardingConversation extends Conversation
{
    protected $firstname;

    public function askFirstname()
    {
        $this->ask(Question::create("naber babajım ya?"), function (Answer $answer) {
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you ' . $this->firstname);
        });

    }
    public function run()
    {
// This will be called immediately
        $this->askFirstname();
    }
}

$botman = BotManFactory::create($config, new LaravelCache());
// Give the bot something to listen for.
$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello canım.');
    $bot->startConversation(new OnboardingConversation());
});

// Start listening
$botman->listen();


