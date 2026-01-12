<div style="font-family: Arial, sans-serif; color:#111;">
    <h2>Bem-vindo(a), {{ $user->name }}!</h2>
    <p>Seu cadastro foi aprovado na <strong>Boxing House PF</strong>.</p>
    <p>Acesse o sistema pelo link: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
    <p>
        <strong>Login:</strong> {{ $user->email }}<br>
        <strong>Senha inicial:</strong> {{ $senha }}
    </p>
    <p>Por segurança, altere sua senha após o primeiro acesso.</p>
    <p>Qualquer dúvida, fale conosco pelo WhatsApp.</p>
    <p>Abraços,<br>Equipe Boxing House PF</p>
</div>
