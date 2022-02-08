<?php


namespace app\engine;


class Session
{
    public function start() {
        session_start();
    }

    public function destroy() {
        session_destroy();
    }

    public function regenerate() {
        session_regenerate_id();
    }

    public function id() {
        return session_id();
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key];
    }
}