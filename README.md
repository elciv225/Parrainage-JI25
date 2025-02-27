```md
# 🎓 Parrainage JI25

Plateforme de parrainage entre étudiants développée avec **PHP**, **MySQL** et un **frontend optimisé avec Vite**.

---

## 📌 **Prérequis**
Avant de commencer, assure-toi d'avoir installé :
- **Docker** 🐳 (https://docs.docker.com/get-docker/)
- **Node.js et npm** 🛠️ (https://nodejs.org/)
- **Git** 📂 (https://git-scm.com/)

---

## 🚀 **Installation & Démarrage**

### **1️⃣ Cloner le projet**
```bash
git clone https://github.com/elciv225/Parrainage-JI25.git
cd Parrainage-JI25
```

### **2️⃣ Installer et builder le frontend**
Le frontend utilise **Vite** pour optimiser les fichiers **JS et CSS**.  
Exécute ces commandes :
```bash
cd src/frontend
npm install
npm run build
```

✅ **Les fichiers statiques optimisés seront placés dans** `backend/client/assets/`.

### **3️⃣ Lancer l'application avec Docker**
```bash
cd ../..  # Revenir à la racine du projet
docker-compose up --build -d
```

### **4️⃣ Accéder à l'application**
Ouvre ton navigateur et entre l'URL :
```bash
http://localhost:8081/
```

---

## 🎯 **Technologies utilisées**
| Technologie | Description |
|------------|------------|
| **PHP 8.2 + Apache** | Backend et serveur web |
| **MySQL 8.0** | Base de données |
| **Node.js + Vite** | Build et optimisation du frontend |
| **Docker + Docker Compose** | Conteneurisation de l'application |

---

## ⚙️ **Commandes utiles**
📌 **Démarrer l’application** :
```bash
docker-compose up -d
```

📌 **Arrêter l’application** :
```bash
docker-compose down
```

📌 **Recréer les containers après modification** :
```bash
docker-compose up --build -d
```

📌 **Voir les logs en direct** :
```bash
docker-compose logs -f
```

---

## 📂 **Structure du projet**
```
Parrainage-JI25/
│── src/
│   ├── backend/           # Code backend (PHP)
│   ├── frontend/          # Code frontend (JS, CSS, Vite)
│   ├── database/          # Scripts SQL pour la base de données
│── docker-compose.yaml    # Configuration Docker
│── Dockerfile             # Image PHP + Apache
│── README.md              # Documentation
│── .env                   # Variables d'environnement (ex. accès DB)
```

---

## 📌 **Contribuer**
💡 **Tu veux contribuer ?**
1. **Forke** le repo sur GitHub
2. **Clone** ton fork sur ta machine :
   ```bash
   git clone https://github.com/ton-pseudo/Parrainage-JI25.git
   ```
3. **Crée une branche** pour ta feature :
   ```bash
   git checkout -b feature/ma-fonctionnalite
   ```
4. **Fais tes modifications et commits** :
   ```bash
   git add .
   git commit -m "Ajout de ma fonctionnalité"
   ```
5. **Envoie tes modifications** :
   ```bash
   git push origin feature/ma-fonctionnalite
   ```
6. **Ouvre une pull request** sur GitHub 🚀

---

## 🛠️ **Problèmes ou questions ?**
Tu as un problème ou une question ?  
🔹 **Ouvre une issue sur GitHub** ! 📩

---

🚀 **Déployé avec Docker, optimisé avec Vite, et prêt à l’emploi !** 🎉
```