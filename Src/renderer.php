<?php
class Renderer {
    public function render(string $viewPath): void {
        $fullPath = __DIR__ . '/../src/views/' . $viewPath;

        require $fullPath;
    }
}
