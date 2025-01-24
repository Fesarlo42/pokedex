CREATE DATABASE IF NOT EXISTS `pokedex` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pokedex`;


--
-- Table structure for table `pokemon_types`
--
CREATE TABLE IF NOT EXISTS `pokemon_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  PRIMARY KEY (`id`),
  INDEX (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `pokemon`
--
CREATE TABLE IF NOT EXISTS `pokemon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type_1` varchar(255),
  `type_2` varchar(255),
  `description` text NOT NULL,

  PRIMARY KEY (`id`),
  FOREIGN KEY (`type_1`) REFERENCES `pokemon_types`(`name`),
  FOREIGN KEY (`type_2`) REFERENCES `pokemon_types`(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `users`
--
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `poke_teams`
--
CREATE TABLE IF NOT EXISTS `poke_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pokemon` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`pokemon`) REFERENCES `pokemon`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Dumping data for table `pokemon_types`
--

INSERT INTO `pokemon_types` (`id`, `name`) VALUES
(1, 'Normal'),
(2, 'Fire'),
(3, 'Water'),
(4, 'Electric'),
(5, 'Grass'),
(6, 'Ice'),
(7, 'Fighting'),
(8, 'Poison'),
(9, 'Ground'),
(10, 'Flying'),
(11, 'Psychic'),
(12, 'Bug'),
(13, 'Rock'),
(14, 'Ghost'),
(15, 'Dragon'),
(16, 'Dark'),
(17, 'Steel'),
(18, 'Fairy');


--
-- Dumping data for table `pokemon`
--

INSERT INTO `pokemon` (`id`, `name`, `slug`, `type_1`, `type_2`, `description`) VALUES
(1, 'Bulbasaur', 'bulbasaur', 'Grass', 'Poison', 'Bulbasaur es un Pokémon tipo planta/veneno que lleva un bulbo en su espalda. Este bulbo almacena energía y crece conforme Bulbasaur lo hace. Vive en praderas y bosques, donde aprovecha el sol para fortalecer su bulbo y prepararse para su evolución. Es amigable, pero también puede defenderse usando látigos y polvo venenoso.'),
(2, 'Ivysaur', 'ivysaur', 'Grass', 'Poison', 'La evolución de Bulbasaur, Ivysaur, desarrolla una flor en su bulbo. Necesita mucho sol para florecer por completo. Aunque es más lento que su preevolución debido al peso de la flor, es mucho más fuerte y puede usar látigos y esporas con gran efectividad.'),
(3, 'Venusaur', 'venusaur', 'Grass', 'Poison', 'Venusaur es la forma final de Bulbasaur. Su gran flor emite un aroma calmante que puede reducir la tensión en otros Pokémon. Este Pokémon es poderoso y majestuoso, capaz de generar ataques devastadores como Rayo Solar y de soportar grandes daños.'),
(4, 'Charmander', 'charmander', 'Fire', NULL, 'Charmander es un Pokémon tipo fuego con una llama en la punta de su cola. Esta llama representa su salud y emociones: arde intensamente cuando está feliz o emocionado y se apaga si está débil. Es curioso y aventurero, pero necesita cuidado para evitar que su llama se extinga.'),
(5, 'Charmeleon', 'charmeleon', 'Fire', NULL, 'Al evolucionar, Charmander se convierte en Charmeleon, un Pokémon más agresivo y fuerte. Usa su cola ardiente y garras afiladas en combate. Es valiente y busca oponentes fuertes para probar su poder.'),
(6, 'Charizard', 'charizard', 'Fire', 'Flying', 'Charizard es la evolución final de Charmander. Este Pokémon volador escupe llamas capaces de derretir incluso piedras. Es un luchador noble que solo usa su poder contra rivales dignos. Su habilidad de volar lo convierte en un explorador incansable.'),
(7, 'Squirtle', 'squirtle', 'Water', NULL, 'Squirtle es un Pokémon tipo agua con un caparazón duro que lo protege de los ataques. Lanza agua desde su boca para defenderse y puede esconderse en su caparazón si está en peligro. Es juguetón y le encanta nadar en ríos y lagos.'),
(8, 'Wartortle', 'wartortle', 'Water', NULL, 'Wartortle es la evolución de Squirtle. Su cola esponjosa lo ayuda a nadar con gran agilidad. Este Pokémon es leal y fuerte, y su caparazón lleva marcas de batalla como prueba de su experiencia.'),
(9, 'Blastoise', 'blastoise', 'Water', NULL, 'La forma final de Squirtle, Blastoise, tiene cañones de agua en su caparazón. Usa estos cañones para atacar con gran precisión y fuerza. A pesar de su tamaño, es muy ágil en el agua y sirve como un defensor formidable.'),
(10, 'Caterpie', 'caterpie', 'Bug', NULL, 'Caterpie es una oruga pequeña y pacífica. Su cuerpo está cubierto de una piel flexible que puede soportar ataques ligeros. Usa su seda para protegerse y escalar árboles mientras busca hojas para comer.'),
(11, 'Metapod', 'metapod', 'Bug', NULL, 'Cuando Caterpie evoluciona a Metapod, se encierra en un caparazón duro mientras se prepara para convertirse en Butterfree. Aunque parece indefenso, su caparazón es extremadamente resistente, y permanece inmóvil para ahorrar energía.'),
(12, 'Butterfree', 'butterfree', 'Bug', 'Flying', 'Butterfree es la forma final de Caterpie. Este Pokémon volador tiene alas cubiertas de polvo especial que usa para repeler enemigos. Es un excelente polinizador y vuela de flor en flor buscando néctar.'),
(13, 'Weedle', 'weedle', 'Bug', 'Poison', 'Weedle es una pequeña oruga venenosa con un aguijón afilado en su cabeza. Aunque es pequeño, puede ser peligroso si se siente amenazado. Vive en bosques y áreas con mucha vegetación.'),
(14, 'Kakuna', 'kakuna', 'Bug', 'Poison', 'Cuando Weedle evoluciona, se convierte en Kakuna. Durante esta fase, permanece inmóvil mientras su cuerpo interno se desarrolla. Aunque no puede atacar, está protegido por su caparazón duro.'),
(15, 'Beedrill', 'beedrill', 'Bug', 'Poison', 'Beedrill es la evolución final de Weedle, un Pokémon insecto/veneno con aguijones en sus brazos. Es extremadamente territorial y ataca en enjambres si siente que su nido está en peligro.'),
(16, 'Pidgey', 'pidgey', 'Normal', 'Flying', 'Pidgey es un ave pequeña y pacífica que evita peleas siempre que puede. Su excelente sentido de dirección lo ayuda a regresar a su nido desde cualquier lugar.'),
(17, 'Pidgeotto', 'pidgeotto', 'Normal', 'Flying', 'Pidgeotto es la evolución de Pidgey. Es más fuerte y agresivo, patrullando su territorio y defendiendo su hogar con determinación.'),
(18, 'Pidgeot', 'pidgeot', 'Normal', 'Flying', 'Pidgeot es un Pokémon majestuoso y rápido, conocido por su elegante plumaje y su habilidad para volar grandes distancias a gran velocidad. Es un depredador que caza con precisión.'),
(19, 'Rattata', 'rattata', 'Normal', NULL, 'Rattata es un roedor rápido y adaptable. Vive en casi cualquier lugar y está siempre alerta, buscando comida o evitando peligros.'),
(20, 'Raticate', 'raticate', 'Normal', NULL, 'Raticate, la evolución de Rattata, tiene colmillos grandes y fuertes capaces de morder madera y metal. Es un Pokémon territorial y protector de su espacio.'),
(21, 'Spearow', 'spearow', 'Normal', 'Flying', 'Spearow es un ave pequeña pero agresiva. Usa su grito fuerte para intimidar a los enemigos y alertar a sus compañeros.'),
(22, 'Fearow', 'fearow', 'Normal', 'Flying', 'Fearow es la evolución de Spearow. Este Pokémon tiene alas poderosas que le permiten volar largas distancias sin descansar.'),
(23, 'Ekans', 'ekans', 'Poison', NULL, 'Ekans es una serpiente silenciosa que se desliza entre la hierba para cazar. Se enrosca para descansar o atacar rápidamente a sus presas.'),
(24, 'Arbok', 'arbok', 'Poison', NULL, 'Arbok, la evolución de Ekans, tiene un patrón intimidante en su vientre que utiliza para asustar a sus enemigos. Es extremadamente territorial y protector.'),
(25, 'Pikachu', 'pikachu', 'Electric', NULL, 'Cada vez que Pikachu se encuentra con algo nuevo, le lanza una descarga eléctrica. Si te encuentras con una baya ennegrecida, es evidencia de que este Pokémon confundió la intensidad de su carga.'),
(26, 'Raichu', 'raichu', 'Electric', NULL, 'Raichu es la evolución de Pikachu. Su cuerpo almacena grandes cantidades de electricidad, que libera a través de su cola. Aunque más grande y fuerte, sigue siendo un Pokémon ágil y juguetón.'),
(27, 'Sandshrew', 'sandshrew', 'Ground', NULL, 'Sandshrew es un Pokémon terrestre que vive en regiones áridas. Su piel dura lo protege del calor y de los ataques enemigos. Se enrolla en una bola para defenderse.'),
(28, 'Sandslash', 'sandslash', 'Ground', NULL, 'Sandslash, la evolución de Sandshrew, tiene garras afiladas que usa para cavar y atacar. Es un Pokémon resistente, adaptado para sobrevivir en condiciones extremas.'),
(29, 'Nidoran♀', 'nidoran-f', 'Poison', NULL, 'Este pequeño Pokémon veneno tiene orejas sensibles que detectan peligros. Aunque parece inofensivo, sus espinas contienen veneno.'),
(30, 'Nidorina', 'nidorina', 'Poison', NULL, 'Nidorina es la evolución de Nidoran♀. Prefiere evitar conflictos, pero si es necesario, usa sus afiladas espinas para defenderse.'),
(31, 'Nidoqueen', 'nidoqueen', 'Poison', 'Ground', 'Nidoqueen es poderosa y protectora, especialmente con su territorio. Su cuerpo robusto y sus ataques venenosos la convierten en una oponente temible.'),
(32, 'Nidoran♂', 'nidoran-m', 'Poison', NULL, 'Nidoran♂ es un Pokémon pequeño pero audaz. Sus afiladas espinas y colmillos venenosos lo ayudan a defenderse de enemigos más grandes.'),
(33, 'Nidorino', 'nidorino', 'Poison', NULL, 'Nidorino, la evolución de Nidoran♂, es más agresivo y fuerte. Usa su cuerno venenoso para atacar a sus rivales.'),
(34, 'Nidoking', 'nidoking', 'Poison', 'Ground', 'Nidoking es la forma final de Nidoran♂. Es un Pokémon colosal con fuerza bruta y habilidades venenosas devastadoras.'),
(35, 'Clefairy', 'clefairy', 'Fairy', NULL, 'Clefairy es un Pokémon de aspecto adorable que se dice trae buena suerte. Vive en montañas y baila bajo la luz de la luna.'),
(36, 'Clefable', 'clefable', 'Fairy', NULL, 'Clefable es la evolución de Clefairy. Es un Pokémon elegante que adora los lugares tranquilos. Sus alas le permiten flotar silenciosamente, lo que lo hace difícil de detectar.'),
(37, 'Vulpix', 'vulpix', 'Fire', NULL, 'Vulpix es un Pokémon de tipo Fuego que tiene una cola compuesta por seis llamas. Es un Pokémon tímido y hermoso, que puede controlar el fuego de sus colas a voluntad. Su aspecto adorable es engañoso, ya que puede ser muy peligroso cuando se siente amenazado.'),
(38, 'Ninetales', 'ninetales', 'Fire', NULL, 'Ninetales es la evolución de Vulpix, un Pokémon de tipo Fuego. Con nueve colas de fuego que se mueven con gracia, Ninetales tiene habilidades místicas y puede controlar el fuego a niveles extraordinarios. Su elegancia es tan destacada como su poder.'),
(39, 'Jigglypuff', 'jigglypuff', 'Normal', 'Fairy', 'Jigglypuff es un Pokémon de tipo Normal y Hada conocido por su habilidad para cantar canciones que inducen el sueño. Con su cuerpo redondeado y ojos grandes, Jigglypuff puede dormir a cualquier persona o Pokémon que lo escuche, convirtiéndolo en un Pokémon adorable pero peligroso en combate.'),
(40, 'Wigglytuff', 'wigglytuff', 'Normal', 'Fairy', 'Wigglytuff es la evolución de Jigglypuff, con un cuerpo más grande y más fuerte. Al igual que su pre-evolución, tiene la capacidad de hacer dormir a sus oponentes con su canto. Además, su pelaje es muy suave y tiene una gran resistencia.' ),
(41, 'Zubat', 'zubat', 'Poison', 'Flying', 'Zubat es un Pokémon de tipo Veneno y Volador que vive en la oscuridad. Aunque carece de ojos, tiene un excelente sistema de ecolocalización que le permite moverse por cavernas y áreas oscuras sin problemas. Suele ser un poco molesto debido a su alta cantidad de encuentros en las cuevas.'),
(42, 'Golbat', 'golbat', 'Poison', 'Flying', 'Golbat es la evolución de Zubat y es un Pokémon mucho más grande y peligroso. Sus alas grandes le permiten volar rápidamente, y su gran boca está llena de afilados colmillos que usa para drenar la energía de sus oponentes.'),
(43, 'Oddish', 'oddish', 'Grass', 'Poison', 'Oddish es un Pokémon de tipo Planta y Veneno que se parece a una pequeña raíz con hojas. Se alimenta de la luz solar y tiene una conexión muy fuerte con la naturaleza. A pesar de su tamaño pequeño, puede liberar toxinas poderosas cuando se siente amenazado.'),
(44, 'Gloom', 'gloom', 'Grass', 'Poison', 'Gloom es la evolución de Oddish, y su olor extremadamente desagradable es su principal defensa. Es un Pokémon de tipo Planta y Veneno que puede liberar esporas tóxicas para defenderse de los ataques. Su crecimiento es más lento, pero su toxicidad aumenta con el tiempo.'),
(45, 'Vileplume', 'vileplume', 'Grass', 'Poison', 'Vileplume es la forma final de evolución de Oddish. Este Pokémon de tipo Planta y Veneno tiene una gran flor en su cabeza que libera polen venenoso en grandes cantidades. Es conocido por su resistencia y por poder envenenar a sus enemigos con facilidad.'),
(46, 'Paras', 'paras', 'Bug', 'Grass', 'Paras es un Pokémon de tipo Bicho y Planta. Se caracteriza por los hongos que crecen en su espalda, los cuales controlan su comportamiento. A pesar de su pequeña apariencia, Paras puede ser muy peligroso si no se le enfrenta adecuadamente.'),
(47, 'Parasect', 'parasect', 'Bug', 'Grass', 'Parasect es la evolución de Paras. Con un hongo más grande en su espalda, este Pokémon de tipo Bicho y Planta es aún más controlado por el hongo, lo que lo hace más agresivo y difícil de manejar. Su habilidad para utilizar esporas lo convierte en un oponente formidable.'),
(48, 'Venonat', 'venonat', 'Bug', 'Poison', 'Venonat es un Pokémon de tipo Bicho y Veneno, que se asemeja a un pequeño insecto con grandes ojos. A pesar de su apariencia inofensiva, Venonat es capaz de liberar polvo venenoso de sus antenas para paralizar a sus enemigos y protegerse.'),
(49, 'Venomoth', 'venomoth', 'Bug', 'Poison', 'Venomoth es la evolución de Venonat. Este Pokémon de tipo Bicho y Veneno tiene alas moradas y la habilidad de liberar polvos venenosos que aturden a sus enemigos. Su velocidad y agilidad en el vuelo lo hacen muy difícil de atrapar.'),
(50, 'Diglett', 'diglett', 'Ground', NULL, 'Diglett es un Pokémon de tipo Tierra que vive bajo tierra. Se caracteriza por su pequeña forma, solo mostrando su cabeza en el suelo. Aunque parece frágil, Diglett tiene la capacidad de excavar rápidamente y atacar con fuerza desde debajo de la tierra.'),
(51, 'Dugtrio', 'dugtrio', 'Ground', NULL, 'Dugtrio es la evolución de Diglett. Este trío de Digletts trabaja en conjunto para excavar de manera aún más rápida y crear terremotos. Aunque cada uno tiene un cuerpo pequeño, su fuerza combinada es formidable en combate.'),
(52, 'Meowth', 'meowth', 'Normal', NULL, 'Meowth es un Pokémon de tipo Normal, conocido por su actitud traviesa. Es famoso por su aparición en el anime como uno de los miembros de Team Rocket, y es capaz de caminar sobre dos patas y robar objetos debido a su agilidad.'),
(53, 'Persian', 'persian', 'Normal', NULL, 'Persian es la evolución de Meowth y es un Pokémon de tipo Normal con una apariencia más elegante. Con su pelaje suave y su naturaleza sigilosa, Persian es muy ágil en combate y en el robo, siendo un Pokémon que destaca por su astucia.'),
(54, 'Psyduck', 'psyduck', 'Water', NULL, 'Psyduck es un Pokémon de tipo Agua, que tiene un dolor constante en su cabeza. Este dolor provoca que Psyduck tenga ataques psíquicos de forma impredecible. Aunque parece torpe, es un Pokémon que se convierte en un gran luchador cuando sus poderes psíquicos se activan.'),
(55, 'Golduck', 'golduck', 'Water', NULL, 'Golduck es la evolución de Psyduck. Este Pokémon de tipo Agua es mucho más rápido y tiene un mayor control sobre sus habilidades psíquicas. A pesar de su aspecto tranquilo, Golduck es un luchador formidable, con movimientos psíquicos muy poderosos.'),
(56, 'Mankey', 'mankey', 'Fighting', NULL, 'Mankey es un Pokémon de tipo Lucha conocido por su temperamento explosivo. Se enfurece fácilmente y ataca con movimientos rápidos y certeros. Vive en grupos y su fuerza radica en su ferocidad.'),
(57, 'Primeape', 'primeape', 'Fighting', NULL, 'Primeape es la evolución de Mankey, un Pokémon de tipo Lucha aún más agresivo. Su ira es constante, lo que lo convierte en un luchador temible. Ataca sin piedad y nunca se detiene hasta ganar.'),
(58, 'Growlithe', 'growlithe', 'Fire', NULL, 'Growlithe es un Pokémon de tipo Fuego leal y valiente, similar a un cachorro. Protege a su entrenador con fervor y utiliza su fuego para ahuyentar enemigos. Es conocido por su excelente olfato.'),
(59, 'Arcanine', 'arcanine', 'Fire', NULL, 'Arcanine es la evolución de Growlithe, un Pokémon de tipo Fuego elegante y poderoso. Es extremadamente rápido, alcanzando grandes velocidades mientras corre. Se considera un símbolo de valentía.'),
(60, 'Poliwag', 'poliwag', 'Water', NULL, 'Poliwag es un Pokémon de tipo Agua con un cuerpo redondeado y una espiral en su barriga. Es ágil nadando y usa su cola como propulsor. Es muy amistoso, pero también puede ser un luchador hábil.'),
(61, 'Poliwhirl', 'poliwhirl', 'Water', NULL, 'Poliwhirl es la evolución de Poliwag. Su cuerpo es más grande y fuerte, y es capaz de usar ataques de agua con gran precisión. Aunque parece tranquilo, es muy efectivo en combate.'),
(62, 'Poliwrath', 'poliwrath', 'Water', 'Fighting', 'Poliwrath es la evolución final de Poliwag. Este Pokémon de tipo Agua y Lucha combina su fuerza física con movimientos acuáticos, lo que lo convierte en un oponente formidable.'),
(63, 'Abra', 'abra', 'Psychic', NULL, 'Abra es un Pokémon de tipo Psíquico conocido por su habilidad para teletransportarse constantemente. Aunque parece dormido, su mente siempre está activa y alerta.'),
(64, 'Kadabra', 'kadabra', 'Psychic', NULL, 'Kadabra es la evolución de Abra, un Pokémon de tipo Psíquico que usa sus poderes mentales para doblar cucharas y lanzar ataques psíquicos. Su inteligencia es increíblemente alta.'),
(65, 'Alakazam', 'alakazam', 'Psychic', NULL, 'Alakazam es la evolución final de Abra. Su cerebro es tan avanzado que puede realizar cálculos complicados en un instante. Usa cucharas para canalizar su energía psíquica.'),
(66, 'Machop', 'machop', 'Fighting', NULL, 'Machop es un Pokémon de tipo Lucha conocido por su gran fuerza física. Desde pequeño, Machop entrena para perfeccionar sus habilidades de combate y se prepara para convertirse en un luchador aún más fuerte. Su disciplina es notable en las batallas.'),
(67, 'Machoke', 'machoke', 'Fighting', NULL, 'Machoke es la evolución de Machop. Con un cuerpo más musculoso, Machoke es un Pokémon de tipo Lucha más poderoso. Es capaz de levantar grandes pesos y de derrotar a otros Pokémon con su impresionante fuerza física.'),
(68, 'Machamp', 'machamp', 'Fighting', NULL, 'Machamp es la evolución final de Machoke. Con cuatro brazos y una fuerza increíble, Machamp es un Pokémon de tipo Lucha extremadamente fuerte. Es capaz de realizar ataques devastadores y derrotar a varios oponentes a la vez en combate.'),
(69, 'Bellsprout', 'bellsprout', 'Grass', 'Poison', 'Bellsprout es un Pokémon de tipo Planta y Veneno que parece una planta con forma de campana. Su habilidad para moverse como si fuera una cuerda le permite atacar a sus enemigos con rapidez y precisión, utilizando chorros de agua a presión.'),
(70, 'Weepinbell', 'weepinbell', 'Grass', 'Poison', 'Weepinbell es la evolución de Bellsprout. Este Pokémon de tipo Planta y Veneno tiene una gran boca que utiliza para capturar presas y drenarlas de energía. Su capacidad para controlar el veneno lo convierte en un oponente peligroso.'),
(71, 'Victreebel', 'victreebel', 'Grass', 'Poison', 'Victreebel es la evolución final de Bellsprout. Con una gran flor en su cabeza, Victreebel usa su poder para atrapar a sus presas y drenarlas de su vitalidad. Su capacidad para liberar esporas tóxicas lo hace aún más letal.'),
(72, 'Tentacool', 'tentacool', 'Water', 'Poison', 'Tentacool es un Pokémon de tipo Agua y Veneno, similar a una medusa. Tiene tentáculos que pueden liberar veneno, lo que lo convierte en un peligro para cualquier ser que se acerque demasiado al agua en la que vive.'),
(73, 'Tentacruel', 'tentacruel', 'Water', 'Poison', 'Tentacruel es la evolución de Tentacool. Es un Pokémon más grande y peligroso, con tentáculos aún más largos que liberan un veneno muy potente. Su capacidad para moverse rápidamente en el agua lo hace difícil de atrapar.'),
(74, 'Geodude', 'geodude', 'Rock', 'Ground', 'Geodude es un Pokémon de tipo Roca y Tierra. Con su cuerpo compuesto de piedras y brazos fuertes, Geodude es resistente a los ataques físicos y es muy bueno en combate cuerpo a cuerpo. Se encuentra comúnmente en las montañas.'),
(75, 'Graveler', 'graveler', 'Rock', 'Ground', 'Graveler es la evolución de Geodude. Más grande y fuerte, este Pokémon de tipo Roca y Tierra tiene un gran poder físico y puede lanzar rocas a gran velocidad para atacar a sus enemigos.'),
(76, 'Golem', 'golem', 'Rock', 'Ground', 'Golem es la evolución final de Geodude. Este Pokémon de tipo Roca y Tierra es extremadamente resistente y pesado, capaz de causar terremotos con su enorme fuerza y resistencia. Su cuerpo de piedra lo hace casi imparable en combate.'),
(77, 'Ponyta', 'ponyta', 'Fire', NULL, 'Ponyta es un Pokémon de tipo Fuego que se parece a un caballo con llamas en su melena y cola. Es rápido y ágil, capaz de correr a velocidades altísimas, y utiliza el fuego como su principal fuente de energía en combate.'),
(78, 'Rapidash', 'rapidash', 'Fire', NULL, 'Rapidash es la evolución de Ponyta. Con un cuerpo más grande y majestuoso, Rapidash es un Pokémon de tipo Fuego que puede correr a velocidades extremadamente altas, generando llamas a su paso.'),
(79, 'Slowpoke', 'slowpoke', 'Water', 'Psychic', 'Slowpoke es un Pokémon de tipo Agua y Psíquico, conocido por su lentitud y su actitud despreocupada. Aunque es torpe, cuando se enfoca, puede utilizar poderosos ataques psíquicos.'),
(80, 'Slowbro', 'slowbro', 'Water', 'Psychic', 'Slowbro es la evolución de Slowpoke. Este Pokémon tiene una naturaleza más centrada y su cola es ocupada por un Shellder que lo ayuda a incrementar su poder psíquico. Es un luchador más astuto y resistente que su pre-evolución.'),
(81, 'Magnemite', 'magnemite', 'Electric', 'Steel', 'Magnemite es un Pokémon de tipo Eléctrico y Acero. Tiene la capacidad de generar un campo magnético que le permite flotar y atraer objetos metálicos. Es pequeño pero muy útil en combate con su habilidad para generar electricidad.'),
(82, 'Magneton', 'magneton', 'Electric', 'Steel', 'Magneton es la evolución de Magnemite. Al combinar tres Magnemites en uno, este Pokémon de tipo Eléctrico y Acero es más poderoso y tiene mayor capacidad para generar rayos eléctricos.'),
(83, 'FarfetchNULLd', 'farfetchd', 'Normal', 'Flying', 'Farfetch`d es un Pokémon de tipo Normal y Volador. Este Pokémon es conocido por llevar un puerro en su pico, que utiliza como un bastón para defenderse. Es muy hábil en combate con su agilidad.'),
(84, 'Doduo', 'doduo', 'Normal', 'Flying', 'Doduo es un Pokémon de tipo Normal y Volador. Tiene dos cabezas que le permiten estar alerta a su alrededor, y su rapidez en tierra le permite escapar fácilmente de los peligros.'),
(85, 'Dodrio', 'dodrio', 'Normal', 'Flying', 'Dodrio es la evolución de Doduo. Este Pokémon de tipo Normal y Volador tiene tres cabezas, lo que le otorga una increíble capacidad para moverse rápidamente y tomar decisiones rápidas durante los combates.'),
(86, 'Seel', 'seel', 'Water', NULL, 'Seel es un Pokémon de tipo Agua que se parece a una foca. Es un Pokémon amigable y muy habilidoso para nadar rápidamente en el agua.'),
(87, 'Dewgong', 'dewgong', 'Water', 'Ice', 'Dewgong es la evolución de Seel. Es un Pokémon de tipo Agua y Hielo, conocido por su gracia al nadar y por su habilidad para moverse a través del hielo sin problemas.'),
(88, 'Grimer', 'grimer', 'Poison', NULL, 'Grimer es un Pokémon de tipo Veneno que está formado por una masa viscosa de residuos. Es un Pokémon sucio que contamina todo lo que toca, liberando gases venenosos de su cuerpo.'),
(89, 'Muk', 'muk', 'Poison', NULL, 'Muk es la evolución de Grimer. Es un Pokémon más grande y tóxico, con una habilidad para liberar veneno en grandes cantidades, corrompiendo todo a su alrededor.'),
(90, 'Shellder', 'shellder', 'Water', NULL, 'Shellder es un Pokémon de tipo Agua que tiene una concha dura. Es un Pokémon defensivo que puede protegerse de casi cualquier ataque gracias a la resistencia de su caparazón.'),
(91, 'Cloyster', 'cloyster', 'Water', 'Ice', 'Cloyster es la evolución de Shellder. Es un Pokémon de tipo Agua y Hielo con una concha extremadamente dura y puntiaguda, capaz de disparar chorros de agua a gran presión.'),
(92, 'Gastly', 'gastly', 'Ghost', 'Poison', 'Gastly es un Pokémon de tipo Fantasma y Veneno. Tiene una forma gaseosa y es capaz de atravesar paredes y objetos sólidos. Su cuerpo fantasmal es ligero y difícil de capturar.'),
(93, 'Haunter', 'haunter', 'Ghost', 'Poison', 'Haunter es la evolución de Gastly. Este Pokémon de tipo Fantasma y Veneno es más peligroso y puede atacar con potentes poderes psíquicos, causando miedo y terror en sus enemigos.'),
(94, 'Gengar', 'gengar', 'Ghost', 'Poison', 'Gengar es la evolución final de Haunter. Es un Pokémon de tipo Fantasma y Veneno conocido por su habilidad para causar pesadillas y manipular las sombras. Es extremadamente astuto y letal en combate.'),
(95, 'Onix', 'onix', 'Rock', 'Ground', 'Onix es un Pokémon de tipo Roca y Tierra, que tiene un cuerpo largo y serpenteante hecho de piedras. Es resistente y muy fuerte, capaz de derribar rocas y estructuras con su enorme fuerza.'),
(96, 'Drowzee', 'drowzee', 'Psychic', NULL, 'Drowzee es un Pokémon de tipo Psíquico que induce el sueño a sus oponentes utilizando poderes hipnóticos. Se alimenta de los sueños de otros y tiene una afinidad especial con las personas que experimentan pesadillas.'),
(97, 'Hypno', 'hypno', 'Psychic', NULL, 'Hypno, la evolución de Drowzee, utiliza su péndulo para hipnotizar y controlar a sus enemigos. Este Pokémon de tipo Psíquico es conocido por su misterioso comportamiento y por su capacidad para manipular los pensamientos ajenos.'),
(98, 'Krabby', 'krabby', 'Water', NULL, 'Krabby es un Pokémon de tipo Agua que habita en playas y costas. Sus grandes pinzas son herramientas versátiles, usándolas tanto para defenderse como para partir su alimento. Es pequeño pero extremadamente valiente.'),
(99, 'Kingler', 'kingler', 'Water', NULL, 'Kingler, la evolución de Krabby, posee unas pinzas enormes con una fuerza devastadora, capaces de partir incluso rocas. Este Pokémon de tipo Agua es un nadador ágil y un luchador temible tanto en tierra como en mar.'),
(100, 'Voltorb', 'voltorb', 'Electric', NULL, 'Voltorb, un Pokémon de tipo Eléctrico, se asemeja a una Poké Ball y se encuentra comúnmente cerca de instalaciones eléctricas. Es inestable y puede explotar fácilmente cuando siente peligro o se sobrecarga de energía.'),
(101, 'Electrode', 'electrode', 'Electric', NULL, 'Electrode, la evolución de Voltorb, almacena grandes cantidades de electricidad en su cuerpo esférico. Este Pokémon de tipo Eléctrico es conocido por liberar descargas masivas y provocar explosiones inesperadas cuando se emociona o se siente amenazado.'),
(102, 'Exeggcute', 'exeggcute', 'Grass', 'Psychic', 'Exeggcute es un grupo de seis semillas que trabajan en equipo. Este Pokémon de tipo Planta y Psíquico usa telepatía para coordinarse y puede atacar con ráfagas psíquicas. Su apariencia oculta su astucia estratégica.'),
(103, 'Exeggutor', 'exeggutor', 'Grass', 'Psychic', 'Exeggutor, la evolución de Exeggcute, es un Pokémon de tipo Planta y Psíquico que parece un árbol tropical con múltiples cabezas. Cada cabeza piensa de forma independiente, lo que le da una gran versatilidad en combate.'),
(104, 'Cubone', 'cubone', 'Ground', NULL, 'Cubone es un Pokémon de tipo Tierra que lleva el cráneo de su madre como casco. Vive solitario y llora por la pérdida de su madre, pero su valentía y determinación lo hacen un luchador formidable.'),
(105, 'Marowak', 'marowak', 'Ground', NULL, 'Marowak es la evolución de Cubone, un Pokémon de tipo Tierra que utiliza un hueso como arma. Es más fuerte y valiente que su preevolución, destacando por su habilidad para ejecutar ataques precisos y contundentes.'),
(106, 'Hitmonlee', 'hitmonlee', 'Fighting', NULL, 'Hitmonlee, un Pokémon de tipo Lucha, es un maestro de las patadas. Sus piernas pueden estirarse para atacar a enemigos lejanos con golpes rápidos y certeros. Su estilo de combate está inspirado en las artes marciales.'),
(107, 'Hitmonchan', 'hitmonchan', 'Fighting', NULL, 'Hitmonchan es un Pokémon de tipo Lucha con una técnica excepcional en golpes de puño. Cada uno de sus ataques está inspirado en diferentes disciplinas de boxeo, combinando fuerza, precisión y resistencia en combate.'),
(108, 'Lickitung', 'lickitung', 'Normal', NULL, 'Lickitung es un Pokémon de tipo Normal con una lengua extremadamente larga que utiliza para atrapar objetos, explorar su entorno o atacar. Es curioso, pero a veces puede ser torpe debido a su tamaño.'),
(109, 'Koffing', 'koffing', 'Poison', NULL, 'Koffing es un Pokémon de tipo Veneno que flota mientras libera gases tóxicos. Aunque parece inofensivo, sus explosiones de gas son devastadoras, y su risa constante lo hace sorprendentemente inquietante.'),
(110, 'Weezing', 'weezing', 'Poison', NULL, 'Weezing, la evolución de Koffing, tiene múltiples cámaras de gas tóxico que utiliza tanto para atacar como para defenderse. Es aún más peligroso debido a la combinación de sus ataques venenosos y explosiones.'),
(111, 'Rhyhorn', 'rhyhorn', 'Ground', 'Rock', 'Rhyhorn es un Pokémon de tipo Roca y Tierra con un cuerpo resistente y una fuerza inmensa. Se lanza a gran velocidad hacia sus enemigos, destruyendo todo a su paso gracias a su poderosa embestida.'),
(112, 'Rhydon', 'rhydon', 'Ground', 'Rock', 'Rhydon es la evolución de Rhyhorn, un Pokémon de tipo Roca y Tierra con un cuerno letal y una piel increíblemente resistente. Puede sobrevivir a la lava y perforar cualquier obstáculo con facilidad.'),
(113, 'Chansey', 'chansey', 'Normal', NULL, 'Chansey es un Pokémon de tipo Normal conocido por su naturaleza amable. Lleva un huevo en su barriga que comparte con Pokémon y humanos como muestra de bondad, y es un símbolo de salud y felicidad.'),
(114, 'Tangela', 'tangela', 'Grass', NULL, 'Tangela es un Pokémon de tipo Planta envuelto en lianas azules que se mueven constantemente. Usa estas lianas para atrapar a sus enemigos y defenderse con látigos poderosos. Es ágil y desconcertante.'),
(115, 'Kangaskhan', 'kangaskhan', 'Normal', NULL, 'Kangaskhan es un Pokémon de tipo Normal que protege ferozmente a su cría, que siempre lleva en su bolsa. Aunque cariñoso con los suyos, muestra una ferocidad inigualable cuando están en peligro.'),
(116, 'Horsea', 'horsea', 'Water', NULL, 'Horsea es un Pokémon de tipo Agua que utiliza chorros de agua para defenderse y cazar. Es ágil nadando y prefiere vivir en aguas tranquilas, donde pasa desapercibido gracias a su pequeño tamaño.'),
(117, 'Seadra', 'seadra', 'Water', NULL, 'Seadra es la evolución de Horsea, un Pokémon de tipo Agua más grande y agresivo. Sus chorros de agua tienen gran presión, y sus afiladas espinas lo convierten en un oponente peligroso.'),
(118, 'Goldeen', 'goldeen', 'Water', NULL, 'Goldeen es un Pokémon de tipo Agua con una apariencia elegante. Usa su cuerno afilado para defenderse, mientras que su nado elegante y ágil lo hace sobresalir en ríos y lagos.'),
(119, 'Seaking', 'seaking', 'Water', NULL, 'Seaking es la evolución de Goldeen, un Pokémon de tipo Agua más fuerte y robusto. Utiliza su cuerno para excavar en el lecho del río y encontrar alimentos, demostrando una gran resistencia.'),
(120, 'Staryu', 'staryu', 'Water', NULL, 'Staryu es un Pokémon de tipo Agua con forma de estrella de mar. Su núcleo central brilla intensamente y puede regenerarse si pierde alguna extremidad. Se oculta bajo el agua para evitar a los depredadores.'),
(121, 'Starmie', 'starmie', 'Water', 'Psychic', 'Starmie es la evolución de Staryu, un Pokémon de tipo Agua y Psíquico con un núcleo multicolor que emite pulsos energéticos. Su brillo hipnotiza a quienes lo observan, y su velocidad lo hace un oponente esquivo.'),
(122, 'Mr. Mime', 'mr-mime', 'Psychic', 'Fairy', 'Mr. Mime es un Pokémon de tipo Psíquico y Hada conocido por su habilidad para crear barreras invisibles y fuertes escudos psíquicos. Es un maestro del mimo, capaz de confundir y frustrar a sus oponentes.'),
(123, 'Scyther', 'scyther', 'Bug', 'Flying', 'Scyther es un Pokémon de tipo Bicho y Volador que combina velocidad y agilidad en combate. Sus cuchillas afiladas le permiten atacar con precisión quirúrgica, y su movimiento rápido lo hace difícil de rastrear.'),
(124, 'Jynx', 'jynx', 'Ice', 'Psychic', 'Jynx es un Pokémon de tipo Hielo y Psíquico con habilidades hipnóticas. Usa su baile rítmico y movimientos hipnotizantes para confundir a sus oponentes. Su naturaleza misteriosa lo convierte en un Pokémon fascinante.'),
(125, 'Electabuzz', 'electabuzz', 'Electric', NULL, 'Electabuzz es un Pokémon de tipo Eléctrico que genera electricidad de alta intensidad. Puede absorber energía eléctrica del entorno y lanzar potentes rayos. Es agresivo y suele causar apagones en las ciudades.'),
(126, 'Magmar', 'magmar', 'Fire', NULL, 'Magmar es un Pokémon de tipo Fuego que habita en volcanes. Su cuerpo emite calor extremo, creando ilusiones en el aire. Ataca lanzando llamaradas y puede derretir casi cualquier material con su energía.'),
(127, 'Pinsir', 'pinsir', 'Bug', NULL, 'Pinsir es un Pokémon de tipo Bicho con grandes pinzas que utiliza para atrapar y aplastar a sus enemigos. Es increíblemente fuerte y puede levantar o partir objetos mucho más grandes que él.'),
(128, 'Tauros', 'tauros', 'Normal', NULL, 'Tauros es un Pokémon de tipo Normal conocido por su ferocidad y energía inagotable. Ataca con embestidas devastadoras y utiliza sus tres colas para dirigir su impulso y desatar su ira en combate.'),
(129, 'Magikarp', 'magikarp', 'Water', NULL, 'Magikarp es un Pokémon de tipo Agua famoso por ser débil y torpe. Aunque parece inofensivo, su capacidad para resistir condiciones extremas le permite evolucionar en un Pokémon increíblemente poderoso.'),
(130, 'Gyarados', 'gyarados', 'Water', 'Flying', 'Gyarados es la evolución de Magikarp, un Pokémon de tipo Agua y Volador temido por su ferocidad. Su ira incontrolable y su capacidad para destruir todo a su paso lo convierten en un adversario temible.'),
(131, 'Lapras', 'lapras', 'Water', 'Ice', 'Lapras es un Pokémon de tipo Agua y Hielo conocido por su naturaleza amable e inteligencia. Es capaz de transportar personas a través del agua y usa su canto para comunicarse con otros de su especie.'),
(132, 'Ditto', 'ditto', 'Normal', NULL, 'Ditto es un Pokémon de tipo Normal capaz de transformarse en cualquier otro Pokémon, copiando tanto su apariencia como sus habilidades. Es increíblemente versátil y puede adaptarse a cualquier situación de combate.'),
(133, 'Eevee', 'eevee', 'Normal', NULL, 'Eevee es un Pokémon de tipo Normal con un ADN inusual que le permite evolucionar en diferentes formas dependiendo de su entorno o los estímulos externos. Es adaptable, curioso y muy querido por los entrenadores.'),
(134, 'Vaporeon', 'vaporeon', 'Water', NULL, 'Vaporeon es la evolución de Eevee con una piedra Agua. Este Pokémon de tipo Agua es ágil en el agua y puede camuflarse al descomponer su cuerpo en partículas similares al agua.'),
(135, 'Jolteon', 'jolteon', 'Electric', NULL, 'Jolteon es la evolución de Eevee con una piedra Trueno. Es un Pokémon de tipo Eléctrico que almacena electricidad en su pelaje. Sus ataques son rápidos y potentes, y su velocidad lo hace casi imparable.'),
(136, 'Flareon', 'flareon', 'Fire', NULL, 'Flareon es la evolución de Eevee con una piedra Fuego. Este Pokémon de tipo Fuego puede almacenar calor interno y liberarlo en forma de llamas intensas. Su cuerpo alcanza temperaturas extremadamente altas.'),
(137, 'Porygon', 'porygon', 'Normal', NULL, 'Porygon es un Pokémon de tipo Normal creado por humanos. Es capaz de entrar en sistemas informáticos y navegar por el ciberespacio. Su diseño único lo hace resistente a virus y fallos digitales.'),
(138, 'Omanyte', 'omanyte', 'Rock', 'Water', 'Omanyte es un Pokémon fósil de tipo Roca y Agua que habitó los mares prehistóricos. Su caparazón en espiral lo protege, y usa sus tentáculos para moverse y atrapar pequeñas presas en el agua.'),
(139, 'Omastar', 'omastar', 'Rock', 'Water', 'Omastar es la evolución de Omanyte, un Pokémon de tipo Roca y Agua. Sus tentáculos son fuertes y precisos, usándolos para cazar y aplastar con su poderosa mandíbula en forma de pico.'),
(140, 'Kabuto', 'kabuto', 'Rock', 'Water', 'Kabuto es un Pokémon fósil de tipo Roca y Agua que se cree extinto. Su caparazón duro le proporciona defensa, y suele permanecer inmóvil para camuflarse en su entorno submarino.'),
(141, 'Kabutops', 'kabutops', 'Rock', 'Water', 'Kabutops es la evolución de Kabuto, un Pokémon de tipo Roca y Agua con cuchillas afiladas en lugar de manos. Es un cazador rápido y letal que vive en aguas poco profundas y es extremadamente ágil.'),
(142, 'Aerodactyl', 'aerodactyl', 'Rock', 'Flying', 'Aerodactyl es un Pokémon de tipo Roca y Volador revivido a partir de fósiles. Es un depredador prehistórico con garras y colmillos afilados, además de ser conocido por su velocidad y fuerza en combate.'),
(143, 'Snorlax', 'snorlax', 'Normal', NULL, 'Snorlax es un Pokémon de tipo Normal conocido por su tamaño colosal y su apetito insaciable. Aunque pasa la mayor parte del tiempo durmiendo, su fuerza despierta es impresionante, y puede ser un aliado poderoso.'),
(144, 'Articuno', 'articuno', 'Ice', 'Flying', 'Articuno es un Pokémon legendario de tipo Hielo y Volador que controla las tormentas de nieve. Su vuelo es majestuoso, y el hielo que crea puede cambiar el clima de regiones enteras.'),
(145, 'Zapdos', 'zapdos', 'Electric', 'Flying', 'Zapdos es un Pokémon legendario de tipo Eléctrico y Volador que genera rayos al batir sus alas. Es temido por su poder destructivo y aparece durante tormentas eléctricas intensas.'),
(146, 'Moltres', 'moltres', 'Fire', 'Flying', 'Moltres es un Pokémon legendario de tipo Fuego y Volador que controla las llamas. Su vuelo enciende el cielo, y sus poderes le permiten renacer de sus cenizas cuando resulta herido.'),
(147, 'Dratini', 'dratini', 'Dragon', NULL, 'Dratini es un Pokémon de tipo Dragón con un cuerpo serpenteante y elegante. Vive en aguas profundas y rara vez es visto. Se dice que está en constante crecimiento, acumulando poder.'),
(148, 'Dragonair', 'dragonair', 'Dragon', NULL, 'Dragonair, la evolución de Dratini, es un Pokémon de tipo Dragón que irradia una energía mística. Puede controlar el clima y usa su elegancia y poder para mantenerse en armonía con la naturaleza.'),
(149, 'Dragonite', 'dragonite', 'Dragon', 'Flying', 'Dragonite es la evolución final de Dratini, un Pokémon de tipo Dragón y Volador. A pesar de su gran tamaño, es amable y protector. Su fuerza y velocidad lo convierten en un aliado confiable.'),
(150, 'Mewtwo', 'mewtwo', 'Psychic', NULL, 'Mewtwo es un Pokémon de tipo Psíquico creado mediante ingeniería genética. Es increíblemente poderoso y difícil de controlar, con habilidades psíquicas que lo convierten en uno de los Pokémon más temidos.'),
(151, 'Mew', 'mew', 'Psychic', NULL, 'Mew es un Pokémon legendario de tipo Psíquico que contiene el ADN de todos los Pokémon. Es juguetón y esquivo, capaz de volverse invisible y utilizar un vasto repertorio de movimientos únicos.');
