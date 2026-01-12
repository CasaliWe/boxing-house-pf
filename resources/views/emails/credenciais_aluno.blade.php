<div style="font-family: Arial, sans-serif; color:#111;">
    <h2>Bem-vindo(a), {{ $user->name }}!</h2>
    <p>Seu cadastro foi aprovado na <strong>Boxing House PF</strong>.</p>
    <p>Acesse o sistema pelo link: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
    <p>
        <strong>Login:</strong> {{ $user->email }}<br>
        <strong>Senha inicial:</strong> {{ $senha }}
    <!-- Email profissional - Boxing House PF -->
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f3f4f6;padding:24px 0;font-family: Arial, Helvetica, sans-serif;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="600" style="background:#111827;border-radius:12px;overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background:#0b1220;padding:20px 24px;color:#60a5fa;font-weight:bold;font-size:20px;letter-spacing:0.5px;">
                            Boxing House PF
                        </td>
                    </tr>

                    <!-- Hero -->
                    <tr>
                        <td style="padding:24px 24px 0;color:#e5e7eb;">
                            <h2 style="margin:0 0 8px;font-size:22px;color:#93c5fd;font-weight:700;">Bem-vindo(a), {{ $user->name }}!</h2>
                            <p style="margin:0;color:#cbd5e1;font-size:14px;line-height:20px;">
                                Seu cadastro foi aprovado e seu acesso ao sistema está liberado.
                            </p>
                        </td>
                    </tr>

                    <!-- Credenciais -->
                    <tr>
                        <td style="padding:16px 24px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#0f172a;border:1px solid #1f2937;border-radius:8px;">
                                <tr>
                                    <td style="padding:16px;color:#e5e7eb;font-size:14px;">
                                        <div style="margin-bottom:8px;color:#9ca3af;">Suas credenciais de acesso</div>
                                        <div style="background:#111827;border:1px solid #1f2937;border-radius:6px;padding:10px;color:#f9fafb;font-family: Consolas, Monaco, 'Courier New', monospace;">
                                            Login: {{ $user->email }}<br/>
                                            Senha inicial: {{ $senha }}
                                        </div>
                                        <div style="margin-top:10px;color:#9ca3af;">Por segurança, altere sua senha após o primeiro acesso.</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td style="padding:8px 24px 24px;" align="center">
                            <a href="{{ route('login') }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:8px;font-weight:600;font-size:14px;">
                                Acessar Agora
                            </a>
                            <div style="margin-top:8px;color:#9ca3af;font-size:12px;">Ou copie e cole: {{ config('app.url') }}</div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#0b1220;color:#9ca3af;padding:16px 24px;font-size:12px;">
                            Caso não tenha solicitado este cadastro, ignore este e-mail.
                            <br/>
                            © {{ date('Y') }} {{ config('app.name', 'Boxing House PF') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
