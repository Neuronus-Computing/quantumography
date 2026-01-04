# 🧠 Quantumography  
### Laravel-Based Image Steganography Platform

> **Quantumography** is a secure Laravel web application that allows users to **hide (encrypt) any type of data inside an image** and later **extract (decrypt) it**, without visibly altering the image.

🌐 Live Demo:  
https://qa.neuronus.net/vangonography

---

## 📌 Overview

Quantumography enables **covert data storage and secure transmission** by embedding secret information inside standard image files (PNG/JPG).  
To the human eye, the image looks completely normal, while the hidden data remains concealed and recoverable only through this application.

This project is built using **Laravel best practices**, focusing on security, clarity, and maintainability.

---

## 🎯 Use Cases

- Secure file sharing  
- Cybersecurity & steganography research  
- Educational demonstrations  
- Digital watermarking  
- Privacy-focused applications  

---

## ✨ Features

- 🖼 Hide any file inside PNG / JPG images  
- 🔓 Extract hidden files from stego-images  
- 🔐 Optional passkey-based encryption  
- ⚡ Fast and lightweight processing  
- 🧩 Clean Laravel MVC architecture  
- 🛡 CSRF protection & input validation  
- 🌐 Web-based interface (no CLI required)

---

## 🧠 How It Works

1. User uploads a **cover image**
2. User uploads a **secret file**
3. Optional passkey encrypts the data
4. Encrypted payload is embedded into the image binary
5. Image is reconstructed and downloaded
6. Reverse process extracts and decrypts the hidden data

The image remains visually unchanged throughout the process.

---

## 🏗️ Tech Stack

| Layer | Technology |
|------|-----------|
| Backend | Laravel 10+ |
| Language | PHP 8.1+ |
| Frontend | Blade / JavaScript / CSS |
| Storage | Laravel Filesystem |
| Security | Laravel Encryption & Validation |
| Server | Apache / NGINX |
