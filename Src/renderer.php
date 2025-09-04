<?php
class Renderer {
    public function render(string $viewPath): void {
        $fullPath = SRC_DIR . 'views/' . $viewPath;
        require $fullPath;
    }
}
