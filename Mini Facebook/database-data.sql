 
CREATE TABLE users( 
     user_id INT PRIMARY KEY AUTO_INCREMENT,
     username VARCHAR(50),
     password VARCHAR(255) NOT NULL,
     is_disabled BOOLEAN DEFAULT FALSE
 );
CREATE TABLE profiles(
     user_id INT PRIMARY KEY,
     name VARCHAR(100),
     additional_email VARCHAR(255),
     email VARCHAR(255) UNIQUE NOT NULL,
     phone VARCHAR(20),
     FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE posts(
     post_id INT PRIMARY KEY AUTO_INCREMENT,
     user_id INT,
     content TEXT,
     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE comments(
     comment_id INT PRIMARY KEY AUTO_INCREMENT,
     post_id INT,
     user_id INT,
     content TEXT,
     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (post_id) REFERENCES posts(post_id),
     FOREIGN KEY (user_id) REFERENCES users(user_id)
);
CREATE TABLE superusers(
     superuser_id INT PRIMARY KEY AUTO_INCREMENT,
     username VARCHAR(50) UNIQUE NOT NULL,
     password VARCHAR(255) NOT NULL
);
CREATE TABLE chat_messages(
     message_id INT PRIMARY KEY AUTO_INCREMENT,
     sender_id INT,
     receiver_id INT,
     content TEXT,
     timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (sender_id) REFERENCES users(user_id),
     FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

INSERT INTO superusers (username,password) VALUES ('admin',md5('admin'));
INSERT INTO users (username,password) VALUES ('admin',md5('admin'));


GRANT ALL ON users TO 'waph_team13'@'localhost';
GRANT ALL ON profiles TO 'waph_team13'@'localhost';
GRANT ALL ON posts TO 'waph_team13'@'localhost';
GRANT ALL ON comments TO 'waph_team13'@'localhost';
GRANT ALL ON superusers TO 'waph_team13'@'localhost';
GRANT ALL ON chat_messages TO 'waph_team13'@'localhost';
