<?php
// controllers/ContactController.php

class ContactController {
    public function index() {
        view('contact', ['title' => 'Контакты']);
    }
}