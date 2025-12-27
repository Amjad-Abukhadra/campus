---
description: Start Laravel Reverb WebSocket server for real-time chat
---

# Starting Laravel Reverb Server

Laravel Reverb is the WebSocket server that enables real-time chat messaging. It must be running for messages to appear instantly for both sender and receiver.

## Quick Start (Manual)

### Option 1: Double-click the batch file
1. Navigate to `d:\laragon\www\campus`
2. Double-click `start-reverb.bat`
3. A command window will open showing the Reverb server status
4. Keep this window open while using the chat

### Option 2: Using Laragon Terminal
1. Open Laragon
2. Click **Terminal** button
3. Run: `php artisan reverb:start`

### Option 3: Using Command Prompt
1. Open Command Prompt
2. Run: `cd d:\laragon\www\campus`
3. Run: `php artisan reverb:start`

---

## Auto-Start Options

### Method 1: Windows Startup Folder (Recommended)

This makes Reverb start automatically when Windows boots.

1. Press `Win + R` to open Run dialog
2. Type: `shell:startup` and press Enter
3. Right-click in the folder → New → Shortcut
4. Browse to: `d:\laragon\www\campus\start-reverb.bat`
5. Name it: "Laravel Reverb Server"
6. Click Finish

**Result**: Reverb will start automatically every time you log into Windows.

---

### Method 2: Windows Task Scheduler

More control over when Reverb starts (e.g., only when Laragon is running).

1. Press `Win + R` and type: `taskschd.msc`
2. Click **Create Basic Task**
3. Name: "Laravel Reverb Server"
4. Trigger: **When I log on**
5. Action: **Start a program**
6. Program: `d:\laragon\www\campus\start-reverb.bat`
7. Finish

**Advanced Options**:
- Right-click the task → Properties
- Conditions tab: Uncheck "Start only if on AC power"
- Settings tab: Check "If task fails, restart every 1 minute"

---

### Method 3: Laragon Auto-Start (If supported)

Some Laragon versions support running scripts on startup.

1. Open Laragon
2. Menu → Preferences → Services & Ports
3. Look for "Run on Startup" or similar option
4. Add: `php artisan reverb:start` to the startup commands

---

## Verifying Reverb is Running

### Check the Console
You should see output like:
```
  INFO  Server running on [0.0.0.0:8080].

  Press Ctrl+C to stop the server
```

### Check in Browser Console
1. Open your chat page
2. Press F12 to open DevTools
3. Go to Console tab
4. Look for WebSocket connection messages
5. Should see: `WebSocket connection established` or similar

### Test Real-Time Messaging
1. Open chat in two different browsers (or incognito + normal)
2. Log in as different users (student and landlord)
3. Send a message from one
4. It should appear instantly in the other without refresh

---

## Troubleshooting

### Port Already in Use
If you see "Address already in use" error:
```bash
# Find what's using port 8080
netstat -ano | findstr :8080

# Kill the process (replace PID with the number from above)
taskkill /PID <PID> /F

# Restart Reverb
php artisan reverb:start
```

### Reverb Keeps Stopping
- Check the console for error messages
- Ensure your `.env` has correct Reverb configuration
- Try running: `php artisan config:clear` then restart Reverb

### Messages Still Not Real-Time
1. Check Reverb is running (see "Verifying" section above)
2. Check browser console for WebSocket errors
3. Verify `.env` has: `BROADCAST_CONNECTION=reverb`
4. Clear cache: `php artisan cache:clear`
5. Hard refresh browser: `Ctrl + Shift + R`

---

## Stopping Reverb

- If running in terminal: Press `Ctrl + C`
- If running via batch file: Close the command window
- If running as startup task: Open Task Manager → End the `php.exe` process running Reverb

---

## Configuration

Check your `.env` file has these settings:

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST="0.0.0.0"
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

If these are missing, run:
```bash
php artisan reverb:install
```
