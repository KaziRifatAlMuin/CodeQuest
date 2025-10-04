<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# CodeQuest – A Problem Recommendation System

CodeQuest is a platform where users can discover, solve, and contribute programming problems.  
It provides personalized recommendations, problem tracking, leaderboards, and a collaborative editorial system — making it easier for users to improve their problem-solving skills while engaging with a competitive and supportive community.

---

## 📌 Features

- **🔮 Problem Recommendation** – Personalized recommendations based on user ratings and topic preferences.  
- **➕ Add New Problems** – Users can contribute by adding new problems to the system.  
- **✅ Track Solved Problems** – Users can mark problems as solved and maintain a history of progress.  
- **🎯 Filtering Options** – Problems can be filtered by tags or ratings for easy discovery.  
- **🏆 Leaderboard & Rating System** – Tracks user performance using a hybrid CodeQuest rating (combining Codeforces ratings + CodeQuest solved problems).  
- **📝 Editorials & Voting** – Community-driven editorials with upvotes/downvotes for ranking best solutions.  

---

## 🗄️ Database Schema

### Entities
- **User**: `userID, name, email, password, role, cf_handle, solved_count, average_rating`  
- **Problem**: `problemID, title, problem_link, rating`  
- **Tag**: `tagID, tag_name`  
- **ProblemTag**: `problemID, tagID`  
- **SolvedProblem**: `userID, problemID, status, solved_at`  
- **Editorial**: `editorialID, userID, problemID, editorial_link, upvotes`  

---

## ⚙️ Tech Stack

- **Database**: MySQL / PostgreSQL  
- **Backend**: (Optional – e.g., Node.js, Django, Laravel)  
- **Frontend**: (Optional – e.g., React, Vue.js, or plain HTML/CSS/JS)  

---

## 🚀 Getting Started

### Prerequisites
- Database system (MySQL/PostgreSQL)  
- Git & any required backend framework  

### Setup
```bash
# Clone the repository
git clone https://github.com/your-username/codequest.git
cd codequest

# Import the database schema
# (SQL file available in /database folder)

# Run the backend server
# (instructions depending on chosen framework)

# Start frontend (if applicable)
