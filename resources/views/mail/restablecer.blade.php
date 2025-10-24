<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>    
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <!-- Contenedor principal -->
                <table role="presentation" width="100%" max-width="600" cellspacing="0" cellpadding="0"
                    style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <!-- Encabezado -->
                    <tr>
                        <td align="center" style="padding: 30px 20px; background-color: #007bff; color: white;">
                            <h1 style="margin: 0; font-size: 24px;">Recuperación de Contraseña</h1>
                        </td>
                    </tr>

                    <!-- Cuerpo del mensaje -->
                    <tr>
                        <td style="padding: 30px 20px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <p>Hola, {{ $user->name }}</p>
                            <p>Un administrador ha solicitado restablecer tu contraseña en el sistema.</p>
                            <p>Haz clic en el botón de abajo para crear una nueva contraseña:</p>

                            <!-- Botón de restablecimiento -->
                            <table role="presentation" cellspacing="0" cellpadding="0" style="margin: 30px auto;">
                                <tr>
                                    <td align="center"
                                        style="background-color: #28a745; padding: 12px 30px; border-radius: 5px;">
                                        <a href="http://127.0.0.1:80/restablecer_pass?token={{ urlencode($token) }}"
                                            target="_blank"
                                            style="color: white; text-decoration: none; font-weight: bold; font-size: 16px;">
                                            Restablecer Contraseña</a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #666666;">
                                Si no solicitaste este cambio, por favor ignora este correo o contacta al administrador
                                del sistema.
                            </p>
                        </td>
                    </tr>

                    <!-- Pie de página -->
                    <tr>
                        <td align="center"
                            style="padding: 20px; background-color: #f8f9fa; color: #6c757d; font-size: 12px;">
                            <p style="margin: 0;">Este correo fue enviado por un administrador del sistema.</p>
                            <p style="margin: 5px 0 0;">© 2025 Tu Empresa. Todos los derechos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
