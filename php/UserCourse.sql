
CREATE DATABASE edsustain;

USE edsustain;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(50) NOT NULL UNIQUE,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    profile_picture VARCHAR(255)
);


CREATE TABLE NotificationSettings (
    user_id INT,
    email_notifications BOOLEAN DEFAULT FALSE,
    promotional_emails BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);


CREATE TABLE PrivacySettings (
    user_id INT,
    show_courses BOOLEAN DEFAULT FALSE,
    show_email BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- 建立 Courses 表格
CREATE TABLE Courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category INT,
    course_name VARCHAR(100) NOT NULL,
    course_author VARCHAR(100) NOT NULL
);


CREATE TABLE UserCourses (
    user_id INT,
    course_id INT,
    assignments_grades JSON,
    progress INT DEFAULT 0,
    PRIMARY KEY (user_id, course_id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (course_id) REFERENCES Courses(id)
);
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

INSERT INTO Courses (category, course_name, course_author)
VALUES 
(1, '網美義大利麵的秘訣！42號混凝土與帕瑪森的完美交織', '元智資傳 Fred'),
(2, '這才叫真正的調色！Photoshop 與 Davinci Resolve 的調色協作', '總統府拖地工'),
(2, 'Godot 遊戲引擎入門：從 2D 到 3D 的 Unity 刻星', '小李飛刀飛啊飛');
