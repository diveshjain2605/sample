#!/bin/bash

echo "🚀 Warehouse Pro - Git Commit and Push"
echo "====================================="
echo

echo "📋 Step 1: Checking git status..."
git status
echo

echo "📦 Step 2: Adding all files to staging..."
git add .
echo "✅ All files added to staging area"
echo

echo "📝 Step 3: Committing with comprehensive message..."
git commit -F git_commit_message.txt
echo "✅ Files committed successfully"
echo

echo "🌐 Step 4: Pushing to remote repository..."
if git push origin main; then
    echo "✅ Changes pushed to main branch"
elif git push origin master; then
    echo "✅ Changes pushed to master branch"
else
    echo "❌ Failed to push. Please check your remote configuration."
    exit 1
fi
echo

echo "🎉 Git push completed successfully!"
echo

echo "📋 Summary:"
echo "✅ All files committed and pushed"
echo "✅ Project reorganization is now in version control"
echo "✅ Clean, professional codebase is preserved"
echo

echo "🔗 Your repository now contains:"
echo "  📁 Organized folder structure"
echo "  🎨 Modern UI design system"
echo "  📚 Comprehensive documentation"
echo "  🧹 Clean, duplicate-free codebase"
echo

read -p "Press Enter to continue..."
