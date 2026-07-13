<!DOCTYPE html>
<html lang="id" class="text-sm xl:text-base 2xl:text-lg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard JDIH</title>
    <link rel="stylesheet" href="/assets/css/base.css">
</head>

<body>
    <section class="container min-h-screen bg-linear-to-br from-[#8B0000] to-[#5C0000] flex flex-col items-center justify-center p-4">
        <div class="form-wrapper flex flex-col">
            <header class="mb-8 flex flex-col items-center">
                <div class="logo-icon inline-flex items-center justify-center w-22 h-22 bg-white/10 backdrop-blur-sm rounded-full mb-4 border-2 border-white/20">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-11 text-dashboard-gold">
                        <use href="/assets/icons.svg#icon-shield">
                    </svg>
                </div>
                <h1 class="mb-2 text-3xl text-foreground font-semibold">JDIH DPRD</h1>
                <p class="text-white/80">Kabupaten Batang Hari</p>
                <div class="w-24 h-1 bg-dashboard-gold mx-auto mt-4 rounded-full"></div>
            </header>
            <div class="form-body text-card-foreground flex flex-col gap-6 rounded-xl border border-white/20 bg-white/95 backdrop-blur-sm shadow-2xl">
                <div class="form-header pt-6 px-6 flex flex-col gap-1.5">
                    <h2 class="text-xl text-center">Login Dashboard</h2>
                    <p class="text-muted-foreground text-center">Masukkan kredensial login Anda untuk mengakses Dashboard</p>
                </div>
                <form action="<?= url_to('login') ?>" method="post" class="space-y-4 px-6">
                    <?= csrf_field() ?>
                    <div class="username-input">
                        <label for="username" class="text-sm leading-none font-medium">Username</label>
                        <div class="input relative mt-1.5 mb-1">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute top-1/2 left-2 -translate-y-1/2 text-muted-foreground">
                                <use href="/assets/icons.svg#icon-user-round">
                            </svg>
                            <input id="username" type="text" name="username" value="<?= old('username') ?>" placeholder="Masukkan username anda" class="px-9 py-2 w-full bg-input-background text-sm border border-input rounded-md focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] focus:outline-none placeholder:text-muted-foreground" inputmode="text" autocomplete="username" autofocus required />
                        </div>
                    </div>
                    <div class="password-input">
                        <label for="password" class="text-sm leading-none font-medium">Password</label>
                        <div class="input relative mt-1.5 mb-1">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute top-1/2 left-2 -translate-y-1/2 text-muted-foreground">
                                <use href="/assets/icons.svg#icon-lock-keyhole">
                            </svg>
                            <input id="password" type="password" name="password" placeholder="••••••••" class="px-9 py-2 w-full bg-input-background text-sm border border-input rounded-md focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] focus:outline-none placeholder:text-muted-foreground" inputmode="text" autocomplete="off" required />
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#8B0000] text-foreground py-1.5 rounded-md outline-none cursor-pointer transition-all hover:bg-[#6B0000]">Login</button>
                    <?php if (session('error')): ?>
                        <div class="message-error text-red-600">
                            <p class="text-center"><?= session('error') ?></p>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
        <div class="copyright-text">
            <p class="text-white/60 text-sm mt-4">&copy; <?= date('Y') ?> DPRD Kabupaten Batang Hari</p>
        </div>
    </section>
</body>

</html>