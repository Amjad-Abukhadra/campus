Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d ""d:\laragon\www\campus"" && php artisan reverb:start", 0, False
Set WshShell = Nothing
