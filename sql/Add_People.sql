---- mysql -u root db2 < [file name]


---------------
-- Adding Users
---------------
INSERT INTO `users`(`id`, `email`, `password`, `name`, `phone`) VALUES ('016456789','SBarber@yahoo.com','Password1','Simon Barber','781-555-1234');

INSERT INTO `users`(`id`, `email`, `password`, `name`, `phone`) VALUES ('016273363','JCena@yahoo.com','Password1','John Cena','515-808-2362');

---------------
-- Adding Parents
---------------

INSERT INTO `parents`(`parent_id`) VALUES ('016273363');



---------------
-- Adding Students
---------------

INSERT INTO `students`(`student_id`, `grade`, `parent_id`) VALUES ('016456789','9','016273363');