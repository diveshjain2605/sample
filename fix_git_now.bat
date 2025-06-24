@echo off
echo 🚨 Emergency Git Fix
echo ===================
echo.

echo 🔧 Step 1: Canceling current commit...
git reset

echo 📦 Step 2: Adding all files...
git add .

echo 📝 Step 3: Simple commit...
git commit -m "Project reorganization and UI improvements"

echo 🌐 Step 4: Pushing...
git push

echo.
echo ✅ Fixed! Your changes are now committed and pushed.
pause
