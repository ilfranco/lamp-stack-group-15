<?php  require_once __DIR__ . '/../../config.php' ?>

<html lang="en-US">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <title>
      <?php echo isset($title) ? htmlspecialchars($title) . ' | ' :  '';?>       
      Group 15 LAMP Stack Project
    </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>

    <body class="flex flex-col w-full min-h-screen">
          <main class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">