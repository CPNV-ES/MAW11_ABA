<?php

class Renderer
{
    public function render(string $viewPath, array $params = []): void
    {
        $fullPath = SRC_DIR . 'Views/' . $viewPath;

        if (!file_exists($fullPath)) {
            throw new Exception("La vue $viewPath est introuvable dans $fullPath");
        }

        extract($params);

        require $fullPath;
    }
}