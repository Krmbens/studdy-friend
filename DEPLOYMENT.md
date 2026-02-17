# 🚀 Quick Deployment Guide - Studdy Friend

## ⚡ Fastest Path to Deployment (Railway - 15 minutes)

### 1️⃣ Push to GitHub
```bash
git init
git add .
git commit -m "Initial deployment"
git remote add origin https://github.com/YOUR_USERNAME/studdy-friend.git
git push -u origin main
```

### 2️⃣ Deploy on Railway
1. Go to **[railway.app](https://railway.app)** → Sign in with GitHub
2. Click **"New Project"** → **"Deploy from GitHub repo"**
3. Select your **studdy-friend** repository

### 3️⃣ Set Environment Variables
In Railway dashboard → **Variables** → Add these:

```env
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

### 4️⃣ Generate APP_KEY
Run locally:
```bash
php artisan key:generate --show
```
Copy output → Add as `APP_KEY` in Railway

### 5️⃣ (Optional) Add OpenAI Key
```env
OPENAI_API_KEY=sk-your-key-here
```

### 6️⃣ Deploy & Access
- Railway auto-deploys
- Click **"Generate Domain"** for public URL
- Access: `https://studdy-friend-production.up.railway.app`

---

## 📋 Files Created for Deployment

✅ **nixpacks.toml** - Railway build configuration  
✅ **Procfile** - Process definition  
✅ **build.sh** - Build script for Render  
✅ **start.sh** - Start script  
✅ **.env.example** - Production environment template  
✅ **.agent/workflows/deploy.md** - Detailed workflow  

---

## 🎯 Alternative Platforms

### Render.com
- Free tier with auto-sleep
- Use `build.sh` and `start.sh`
- [render.com](https://render.com)

### Fly.io
- 3 free VMs
- Requires credit card
- [fly.io](https://fly.io)

---

## ✅ Post-Deployment Checklist

- [ ] App loads without errors
- [ ] User registration works
- [ ] Login/logout functional
- [ ] Dashboard displays
- [ ] AI features work (if API key set)
- [ ] PDF generation works
- [ ] Filament admin accessible

---

## 🐛 Common Issues

**"No encryption key"**  
→ Generate and set `APP_KEY`

**Database errors**  
→ Ensure `DB_CONNECTION=sqlite`

**Assets not loading**  
→ Run `npm run build`

**500 errors**  
→ Check Railway logs, temporarily set `APP_DEBUG=true`

---

## 📚 Full Documentation

See **[deployment_guide.md](file:///C:/Users/huawei/.gemini/antigravity/brain/49b0982f-478c-4b58-84dc-14df70f3069f/deployment_guide.md)** for comprehensive instructions.

---

## 🎨 Portfolio Tips

1. **Create demo account** with sample data
2. **Add README badge**: 
   ```markdown
   [![Live Demo](https://img.shields.io/badge/demo-live-success)](https://your-app.railway.app)
   ```
3. **Screenshot your app** for portfolio
4. **Document features** in README

---

**Need help?** Use `/deploy` workflow for step-by-step guidance.
