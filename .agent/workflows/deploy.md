---
description: Deploy the application to Railway.app
---

# Deploy to Railway

This workflow guides you through deploying the Studdy Friend application to Railway.app for free hosting.

## Prerequisites

- GitHub account
- Railway account (sign up at https://railway.app)
- Code pushed to GitHub repository

## Steps

### 1. Prepare Your Repository

Ensure all deployment files are committed:

```bash
git add .
git commit -m "Add deployment configuration"
git push origin main
```

### 2. Create Railway Project

1. Go to https://railway.app and sign in with GitHub
2. Click "New Project"
3. Select "Deploy from GitHub repo"
4. Choose your `studdy-friend` repository
5. Railway will automatically detect it as a PHP project

### 3. Configure Environment Variables

In Railway dashboard:
1. Click on your service
2. Go to "Variables" tab
3. Add the following variables:

```
APP_NAME=Studdy Friend
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
LOG_LEVEL=error
```

### 4. Generate APP_KEY

// turbo
Run locally to generate the key:
```bash
php artisan key:generate --show
```

Copy the output and add it as `APP_KEY` in Railway variables.

### 5. Add OpenAI API Key (Optional)

If you want AI features to work, add:
```
OPENAI_API_KEY=your-openai-key-here
```

### 6. Deploy

Railway will automatically:
- Install dependencies
- Build assets
- Run migrations
- Start the application

Monitor the deployment in the "Deployments" tab.

### 7. Access Your Application

Once deployed, click "Generate Domain" in Railway settings to get a public URL like:
`https://studdy-friend-production.up.railway.app`

### 8. Verify Deployment

Test the following:
- [ ] Homepage loads
- [ ] User registration works
- [ ] Login works
- [ ] Dashboard displays
- [ ] AI features work (if API key configured)

## Troubleshooting

**Issue: Build fails**
- Check the build logs in Railway
- Ensure all dependencies are in `composer.json` and `package.json`

**Issue: Database errors**
- Verify `DB_CONNECTION=sqlite` is set
- Check that migrations ran successfully in logs

**Issue: 500 errors**
- Temporarily set `APP_DEBUG=true` to see detailed errors
- Check Railway logs for error details

## Custom Domain (Optional)

1. In Railway settings, go to "Domains"
2. Click "Custom Domain"
3. Add your domain and follow DNS configuration instructions

## Updating Your App

To deploy updates:
```bash
git add .
git commit -m "Your update message"
git push origin main
```

Railway will automatically redeploy!
