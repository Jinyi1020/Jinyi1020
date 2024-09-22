-- Members Table
CREATE TABLE Members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    UNIQUE (username),
    UNIQUE (email)
);

-- Events Table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    event_date DATE,
    location VARCHAR(255)
);

INSERT INTO events (title, description, event_date, location)
VALUES 
('Freshman Night', 'An engaging night for freshmen to socialize and learn about campus resources', '2024-10-01', 'Main Hall'),
('TARUMT Bazaar', 'An event featuring various first aid demonstrations and workshops', '2024-10-15', 'Room 202'),
('Blood Donation', 'A vital health drive encouraging community members to donate blood', '2024-11-05', 'Community Center');

