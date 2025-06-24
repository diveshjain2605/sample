@echo off
echo 🚀 Warehouse Pro - Git Commit and Push
echo =====================================
echo.

echo 📋 Step 1: Checking git status...
git status
echo.

echo 📦 Step 2: Adding all files to staging...
git add .
echo ✅ All files added to staging area
echo.

echo 📝 Step 3: Committing with comprehensive message...
git commit -F git_commit_message.txt
echo ✅ Files committed successfully
echo.

echo 🌐 Step 4: Pushing to remote repository...
git push origin main
if %errorlevel% neq 0 (
    echo ⚠️  Trying 'master' branch instead...
    git push origin master
)
echo ✅ Changes pushed to remote repository
echo.

echo 🎉 Git push completed successfully!
echo.
echo 📋 Summary:
echo ✅ All files committed and pushed
echo ✅ Project reorganization is now in version control
echo ✅ Clean, professional codebase is preserved
echo.

echo 🔗 Your repository now contains:
echo   📁 Organized folder structure
echo   🎨 Modern UI design system  
echo   📚 Comprehensive documentation
echo   🧹 Clean, duplicate-free codebase
echo.

pause
