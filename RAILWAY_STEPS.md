# Railway Deployment Steps

## ✅ Step 1: Push Code to GitHub
**Status:** In Progress - Waiting for authentication

Once the push completes, proceed to Step 2.

---

## Step 2: Create Railway Account & Project

1. **Go to Railway**: https://railway.app
2. **Sign in with GitHub** (click "Login with GitHub")
3. **Authorize Railway** to access your repositories
4. **Create New Project**:
   - Click "New Project"
   - Select "Deploy from GitHub repo"
   - Choose `Krmbens/studdy-friend`
   - Railway will start deploying automatically

---

## Step 3: Configure Environment Variables

While the first deployment runs (it will fail without env vars), set these up:

1. Click on your service in Railway
2. Go to "Variables" tab
3. Click "New Variable" and add each:

```
APP_NAME=Studdy Friend
APP_ENV=production
APP_DEBUG=false
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
LOG_LEVEL=error
```

4. **Generate APP_KEY locally**:
```bash
php artisan key:generate --show
```
Copy the output and add as `APP_KEY` variable in Railway.

5. **(Optional)** Add OpenAI key if you want AI features:
```
OPENAI_API_KEY=your-key-here
```

---

## Step 4: Trigger Redeploy

After adding environment variables:
1. Go to "Deployments" tab
2. Click the three dots on the latest deployment
3. Click "Redeploy"

---

## Step 5: Generate Public Domain

1. Go to "Settings" tab
2. Scroll to "Networking"
3. Click "Generate Domain"
4. Copy your public URL (e.g., `studdy-friend-production.up.railway.app`)

---

## Step 6: Update APP_URL

1. Go back to "Variables"
2. Update `APP_URL` with your actual Railway domain
3. Redeploy again

---

## Step 7: Verify Deployment

Visit your Railway URL and test:
- [ ] Homepage loads
- [ ] User registration
- [ ] Login
- [ ] Dashboard
- [ ] AI features (if configured)

---

## Troubleshooting

**Build fails?**
- Check logs in Railway dashboard
- Verify all environment variables are set

**500 errors?**
- Temporarily set `APP_DEBUG=true` to see errors
- Check Railway logs

**Database errors?**
- Ensure `DB_CONNECTION=sqlite`
- Check migration logs

---

## Next: Once Deployed

1. Test all features
2. Create demo account with sample data
3. Add live link to your portfolio
4. Share on LinkedIn/GitHub!
