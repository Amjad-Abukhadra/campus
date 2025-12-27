# Quick Setup: Auto-Start Reverb

Follow these steps to make Laravel Reverb start automatically with Windows:

## Step 1: Create Shortcut in Startup Folder

1. Press `Win + R` on your keyboard
2. Type: `shell:startup` and press Enter
3. A folder will open (this is your Windows Startup folder)
4. Right-click in the empty space → **New** → **Shortcut**
5. Click **Browse** and navigate to: `d:\laragon\www\campus\start-reverb.bat`
6. Click **Next**
7. Name it: **Laravel Reverb Server**
8. Click **Finish**

## Step 2: Test It

1. **Restart your computer** (or log out and log back in)
2. After logging in, you should see a command window open automatically
3. The window should show: `Server running on [0.0.0.0:8080]`
4. **Keep this window open** - don't close it!

## Step 3: Verify Real-Time Chat Works

1. Open your chat in browser: `http://campus.test/chat/1`
2. Open another browser (or incognito window)
3. Log in as a different user
4. Send a message from one user
5. **The message should appear instantly in the other browser** ✅

---

## Alternative: Manual Start

If you don't want auto-start, you can manually start Reverb anytime:

1. Go to `d:\laragon\www\campus`
2. Double-click `start-reverb.bat`
3. Keep the window open while using chat

---

## Stopping Reverb

- Close the command window that says "Server running on [0.0.0.0:8080]"
- Or press `Ctrl + C` in that window

---

## Troubleshooting

**If Reverb doesn't start automatically:**
- Check the Startup folder has the shortcut
- Make sure the shortcut points to the correct `.bat` file
- Try running `start-reverb.bat` manually to see if there are errors

**If messages still aren't real-time:**
- Make sure the Reverb window is open and showing "Server running"
- Hard refresh your browser: `Ctrl + Shift + R`
- Check browser console (F12) for WebSocket errors
