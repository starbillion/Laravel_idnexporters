<?php

return [

    'user_model'         => App\User::class,
    'message_model'      => App\MessengerMessage::class,
    'participant_model'  => App\MessengerParticipant::class,
    'thread_model'       => App\MessengerThread::class,
    'messages_table'     => 'messenger_messages',
    'participants_table' => 'messenger_participants',
    'threads_table'      => 'messenger_threads',
];
