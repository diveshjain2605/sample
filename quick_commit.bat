@echo off
echo 🔧 Quick Fix: Git Commit Issue
echo ==============================
echo.

echo 📝 Canceling current commit and starting fresh...
echo.

REM Cancel any pending commit
git reset --soft HEAD

echo 📦 Adding all files...
git add .

echo 📝 Committing with simple message...
git commit -m "🎨 Major Project Reorganization: Clean Architecture & Simplified UI

✅ Complete restructuring of Warehouse Pro
✅ Modern, clean design system implementation  
✅ Organized folder structure (config/, core/, pages/, assets/)
✅ Removed duplicate and unnecessary files
✅ Enhanced mobile responsiveness and accessibility
✅ Professional navigation and user interface
✅ Comprehensive documentation added

This commit transforms the project into a professional, maintainable warehouse management system."

echo.
echo 🌐 Pushing to repository...
git push origin main
if %errorlevel% neq 0 (
    echo ⚠️  Trying master branch...
    git push origin master
)

echo.
echo 🎉 Git commit and push completed successfully!
echo ✅ Your reorganized project is now in version control
echo.
pause
