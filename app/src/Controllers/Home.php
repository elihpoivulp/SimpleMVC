<?php

namespace Simplemvc\Controllers;

use Exception;
use Simplemvc\Core\Controller;
use Simplemvc\Core\Model;
use Simplemvc\Core\Request;
use Simplemvc\Models\MessagesModel;

class Home extends Controller
{
    private Model $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new MessagesModel();
    }

    /**
     * @throws Exception
     */
    public function index(): void
    {
        echo '<h1>Messages</h1>';
        echo '<ul>';
        foreach ($this->model->getMessages() as $message) {
            echo '<li>' . $message['message'] . '</li>';
        }
        echo '</ul>';

    }
    public function addMessage($message): void
    {
        if ($this->model->newMessage($message)) {
            echo 'Message successfully added!';
        } else {
            echo 'Could not add message.';
        }
    }
}