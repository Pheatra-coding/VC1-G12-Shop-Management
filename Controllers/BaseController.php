<?php

class BaseController
{
    // ▼▼▼ EXISTING METHODS (NO CHANGES NEEDED) ▼▼▼
    protected function view($view, $data = []) 
    {
        extract($data);
        ob_start();
        require "views/{$view}.php";
        $content = ob_get_clean();
        require "views/layout.php";
    }

    protected function redirect($url) 
    {
        header("Location: $url");
        exit;
    }

    protected function sendTelegramMessage($message) 
    {
        $url = "https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage";
        $data = [
            'chat_id' => $this->telegramChatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    protected function formatTelegramAlert($products, $title, callable $formatter) 
    {
        if (empty($products)) {
            return '';
        }
        $message = "<b>{$title}</b>\n";
        $message .= "Count: " . count($products) . "\n\n";
        foreach ($products as $product) {
            $message .= $formatter($product) . "\n";
        }
        return $message;
    }

    // ▼▼▼ NEW ADDITIONS FOR AUTOMATIC ALERTS ▼▼▼
    
    /**
     * Start automatic alert scheduler
     * @param int $interval Seconds between alerts (default: 600 = 10 minutes)
     */
    protected function startAlertScheduler($interval = 600)
    {
        // Only start if not already running
        if (!isset($_SESSION['alert_scheduler'])) {
            $_SESSION['alert_scheduler'] = true;
            
            // Run in background after response is sent
            register_shutdown_function(function() use ($interval) {
                ignore_user_abort(true);  // Continue running after browser closes
                set_time_limit(0);       // No time limit
                
                while (true) {
                    $this->sendAutoAlert();  // This will be implemented in child controllers
                    sleep($interval);        // Wait for next cycle
                }
            });
            
            // Optimize for FastCGI if available
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
        }
    }

    /**
     * To be implemented by child controllers
     */
    protected function sendAutoAlert() 
    {
        // Default empty implementation
    }

    /**
     * Telegram credentials (unchanged)
     */
    protected $telegramBotToken = '8061862392:AAG4_dnTPZNFEzBS_FVizTeyqFLJHks8e-I';
    protected $telegramChatId = '1343428557';
}