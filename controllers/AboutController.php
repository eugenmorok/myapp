<?php
// controllers/AboutController.php

class AboutController {
    public function index() {
        view('about', ['title' => 'О нас']);
    }
}