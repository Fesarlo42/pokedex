<footer class="bg-light py-3 mt-5">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="text-muted">Pokedex by Fernanda Gomes</span>
        <span class="text-muted" id="session-time">
            <?php
            if (isset($_COOKIE['login_time'])) {
                $loginTime = $_COOKIE['login_time'];
                $currentTime = time();
                $elapsedTime = $currentTime - $loginTime;

                // Convert to readable format
                $hours = floor($elapsedTime / 3600);
                $minutes = floor(($elapsedTime % 3600) / 60);
                $seconds = $elapsedTime % 60;

                echo "Llevas {$hours}h {$minutes}m {$seconds}s conectado";
            }
            ?>
        </span>
    </div>
</footer>