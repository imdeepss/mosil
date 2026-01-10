<?php
$pageTitle = 'Newsroom';
$blogs = getBlogs(3);
$latestBlogs = getLatestBlogs(5);
$glossary = getGlossary("A", $limit = 3, $offset = 0);
$caseStudiesData = getCaseStudiesWithPagination(1, 3, 'All');
$caseStudies = $caseStudiesData['caseStudies'];




$mosil_news = [
    [
        "category" => "Exhibition",
        "title" => "MOSIL at IME 2025 Exhibition, Kolkata,",
        "date" => "07 May 2025",
        "image" => "ime_exhibition.jpg",
        "is_featured" => true
    ],
    [
        "category" => "News",
        "title" => "Equipment reliability linked with lubrication and lubricants",
        "image" => "car_reliability.jpg",
        "is_featured" => false
    ],
    [
        "category" => "Beyond business",
        "title" => "Beyond business : Ensuring smooth Innovation",
        "image" => "robotic_arm.jpg",
        "is_featured" => false
    ],
    [
        "category" => "News",
        "title" => "Myths about bearing lubrication",
        "image" => "bearing_gear.jpg",
        "is_featured" => false
    ],
    [
        "category" => "News",
        "title" => "Tribotsav 2025: Tribotsav: Spirit of togetherness",
        "image" => "team_photo.jpg",
        "is_featured" => false
    ]
];
$lubricationItems = [
    [
        "title" => "Identify Painpoints",
        "description" => "Understand deeply unique challenges",
        "image" => "/assets/images/ui/IdentifyPainpoints.png"
    ],
    [
        "title" => "Expectation Mapping",
        "description" => "Actively validate not assume",
        "image" => "/assets/images/ui/ExpectationMapping.png"
    ],
    [
        "title" => "TriboIntel",
        "description" => "Tribology based performance documentation",
        "image" => "/assets/images/ui/TriboIntel.png"
    ],
];

$faqs = [
    'Oils' => [
        ['question' => 'What is viscosity of Oil?', 'answer' => 'Viscosity of an oil is a relative thickness that determines the flowability of the oil.'],
        ['question' => 'What is a flash point of an Oil?', 'answer' => 'Flashpoint of an Oil is the temperature at which 5% of the oil starts generating enough vapours to ignite the oil in the presence of an external source.'],
        ['question' => 'The colour of the oil has changed within short duration of putting it in application. Should I throw away the oil as the quality does not seem to be ok?', 'answer' => 'NO. There are few additives incorporated in few types of oils (more common in case of gear oils) that change the colour due to change in the surface chemistry immediately (or within short duration) on coming in contact with rotating surfaces (dynamic load condition). This change is colour is within the known behaviour of the oil and does not affect the performance of the oil adversely (or in any other manner). You may continue to use the oil till its intended life. (You may contact us for any further clarification you require w.r.t. a particular product of MOSIL)'],
        ['question' => 'What is the best place to draw sample of oil for further testing and analysis?', 'answer' => 'The best place to draw a sample of oil is from the downstream of any application. Ideally one should draw as many samples as possible so as to get the most accurate analysis done. E.g. For large lubricating or gear oil systems, draw the sample from the oil in circulation and from the bottom of the sump/ reservoir. In hydraulic systems, draw a sample from the header tank, downstream of filters etc.'],
        ['question' => 'How are base oils classified?', 'answer' => 'Base Oils are classified as Mineral, Synthetic & Vegetable oil. Mineral Oil: Derived from crude oil. Synthetic Oil: Man made through synthesizing process. Vegetable oil: Derived from plants.'],
        ['question' => 'Which are the most important base oil properties?', 'answer' => 'Viscosity, Viscosity Index, Flash Point, Pour Point, Volatility, Oxidation and Thermal stability, Aniline Point (a measure of base oil solvency toward other materials including additives), and Hydrolytic Stability (the lubricants resistance to chemical decomposition in the presence of water).'],
        ['question' => 'In how many groups American Petroleum Institute (API) had categorized all base oils?', 'answer' => 'The American Petroleum Institute (API) has categorized base oils into five categories (Group I to Group V).'],
        ['question' => 'How mineral oils are assigned in these groups?', 'answer' => 'Groups I, II and III are all mineral oils with an increasing severity of the refining process. Group I base oils are created using the solvent-extraction or solvent-refining technology. Group II base oils are produced using hydrogenation or hydrotreating. Group III base oils are made by hydrogenation process coupled with high temperatures and high pressures.'],
        ['question' => 'How synthetic oils are assigned in these groups?', 'answer' => 'Group IV is dedicated to a single type of synthetic oil called polyalphaolefin (PAO). Group V is assigned to all other base oils, particularly synthetics. Some of the most common oils in this group include diesters, polyolesters, polyalkylene glycols, phosphate esters and silicones.'],
        ['question' => 'Why Group III oils sometimes advertised as Synthetics?', 'answer' => 'There is an understanding that the refining process has severely modified the original hydrocarbon, thus synthesizing the more highly pure product.'],
        ['question' => 'Why chosing oil is more important?', 'answer' => 'Whenever you will buy a grease or oil, there will be some expectations in mind such as its service life, higher operating temperatures etc. For meeting these conditions chosing a proper oil as a base component is very useful.'],
        ['question' => 'Even though synthetic oils have many advantages, why mineral oils are popular?', 'answer' => 'While synthetic oil are ideal for applications like engine oils, gear oils, bearing oils and other applications, mineral oil remains the predominant oil of choice due to its lower cost and reasonable service capabilities.'],
        ['question' => 'Which base oil group constitutes major share of the lubrication industry?', 'answer' => 'Group I base oils contribute to approx. 28 % of the lubricants used. Group II base oils holds 47 % of the lubricants used. Group III accounts for less than 1 % of the lubricants used.'],
        ['question' => 'What are additives? And its types?', 'answer' => 'Oil additives are chemical compounds that improve the lubricant performance of base oil. Anti oxidants, Anti foam agents, Antiwear, Extreme pressure, Demulsibility, VI improvers, Corrosion inhibiters are various additives added to oil as per application.']
    ],
    'Grease' => [
        ['question' => 'When should I use grease instead of oil?', 'answer' => 'Grease is ideal for applications where access is limited, sealing is important, or where lubricant needs to stay in place for extended periods.'],
        ['question' => 'What causes grease to harden or dry out?', 'answer' => 'Grease may harden due to oxidation, high temperatures, evaporation of base oil, or contamination over time.'],
        ['question' => 'Can over-lubrication cause problems?', 'answer' => 'Yes, over-lubrication can cause increased friction, leakage, or damage to seals and components.'],
        ['question' => 'What is dielectric grease and where is it used?', 'answer' => 'Dielectric grease is a silicone-based grease used to insulate and protect electrical connections from moisture and corrosion.'],
        ['question' => 'What is oil bleed in grease and is it a problem?', 'answer' => 'Oil bleed is the separation of base oil from the thickener. Moderate bleed is normal, but excessive bleeding can affect performance.'],
        ['question' => 'Can the same lubricant be used for bearings and gears?', 'answer' => 'Not always. Bearings and gears have different load, speed, and lubrication requirements. Use application-specific products.'],
        ['question' => 'Why is regular lubricant analysis important?', 'answer' => 'Routine analysis helps detect contamination, wear, and degradation early, ensuring timely maintenance and preventing failure.'],
        ['question' => 'What are open gear lubricants?', 'answer' => 'These are heavy-duty lubricants designed to withstand extreme loads and slow speeds typically found in large open gear systems.'],
        ['question' => 'What are the signs of lubricant degradation in service?', 'answer' => 'Signs include colour change, foul odour, increased viscosity, sludge formation, and reduced performance.'],
        ['question' => 'Can grease be applied manually or must it always be automated?', 'answer' => 'Both methods are acceptable. Manual greasing is common for low-frequency needs, while automated systems are ideal for continuous or hard-to-reach applications.'],
        ['question' => 'What does \'drop-in replacement\' mean for lubricants?', 'answer' => 'A drop-in replacement lubricant matches the performance and compatibility of the existing lubricant without requiring system changes.'],
        ['question' => 'What is bleed rate in grease?', 'answer' => 'Bleed rate refers to the speed at which oil separates from grease over time. Controlled bleeding helps maintain lubrication, but excessive bleed is undesirable.'],
        ['question' => 'Why does grease dry out in bearings?', 'answer' => 'Grease can dry due to heat exposure, oxidation, or evaporation of base oil, leaving behind thickener residues that reduce lubrication effectiveness.'],
        ['question' => 'What is a grease gun and how is it used?', 'answer' => 'A grease gun is a tool used to apply grease to machine components, often through a grease fitting or nipple. It ensures controlled and targeted lubrication.'],
        ['question' => 'What causes grease to become runny?', 'answer' => 'Heat, mechanical shear, or incompatible mixing can break down the grease structure, leading to oil separation and a runny consistency.'],
        ['question' => 'What are high-load lubricants?', 'answer' => 'These lubricants are formulated to withstand extreme pressure and shock loading, often containing EP or solid additives for heavy-duty applications.'],
        ['question' => 'What are multi-purpose greases?', 'answer' => 'These are greases suitable for a wide range of applications, typically offering balanced performance in wear protection, water resistance, and load-carrying capacity.'],
        ['question' => 'Can over-greasing cause bearing failure?', 'answer' => 'Yes. Over-greasing can increase friction, raise temperatures, and cause seals to rupture, leading to bearing damage.'],
        ['question' => 'What is the role of a thickener in grease?', 'answer' => 'The thickener gives grease its structure, holding the base oil and additives in place. Common thickeners include lithium, calcium, aluminium complexes, lithium complex, barium complex, calcium complex, calcium sulfonate complex etc.']
    ],
    'Food Grade Lubricants' => [
        ['question' => 'What are food-grade lubricants?', 'answer' => 'Food-grade lubricants are specially formulated to be safe for incidental contact with food. They meet strict safety and hygiene standards like NSF H1.'],
        ['question' => 'What are NSF H1, H2, and H3 lubricants?', 'answer' => 'These are food-grade classifications: H1 (incidental food contact), H2 (no food contact), H3 (edible oils for rust prevention).'],
        ['question' => 'What are MOSIL Food Grade Lubricants?', 'answer' => 'MOSIL Food Grade Lubricants are potentially indirect food additives, as they may incidentally come into contact with the food items due to leaks, spillages or faults in equipment. All lubricants used in food processing and packaging must be food grade.'],
        ['question' => 'When is a lubricant food grade?', 'answer' => 'A lubricant qualifies as food-grade when, in the event of contamination, it is no more than 10 mg per kg of the foodstuff in question and must not cause any physiological hazard or affect the food’s odour and taste in any way. Food Grade Lubricants are special blends of base fluids and additives and should confirm to the erstwhile US FDA standards and registered by NSF International in the H1 category.'],
        ['question' => 'How safe are MOSIL Food Grade Lubricants in food production?', 'answer' => 'All products in the MOSIL Food Grade range comply with stringent international standards for Food Grade Lubricants handed down by the NSF International(H1). They are produced in line with the Good Manufacturing Practice and as a part of ISO 9001.'],
        ['question' => 'What are the regulatory standards for food lubricants?', 'answer' => 'In the absence of any international system to regulate Food Grade Lubricants, the industry has adopted the strict requirements of the US System as international best practice.'],
        ['question' => 'What is the US System and does MOSIL Food Grade Lubricants comply?', 'answer' => 'All products in MOSIL Food Grade Range comply with the NSF International (H1), the standard which has replaced previous USDA systems for lubricants where incidental contact with food is likely. MOSIL Food Grade Products also comply with the technical qualifications published in the Federal Register. FDA 21 CFR 178.3570. as well as with the FDA Standards for raw materials used in Food Grade products (such lubricants) within the United States, including imports and exports. In addition, MOSIL Food Grade products are manufactured according to the Good Manufacturing Practice and as a part of ISO 9001.'],
        ['question' => 'Does MOSIL Food Grade Lubricants have USDA H1 approval?', 'answer' => 'There is no obligation for lubricant manufacturers to adhere to the now-defunct USDA H1 rules, nor does the USDA endorse or recognise any past authorisations for Food Grade Lubricants.'],
        ['question' => 'What has replaced USDA H1 approval?', 'answer' => 'NSF(National Sanitary Foundation) International took on the procedures and systems of USDA H1. It continues to manage the USDA list, which is known as the NSF White Book of Proprietary Substances and Nonfood Compounds. NSF registration procedures are identical to the former USDA rules, including the classification H1 and H2 products.'],
        ['question' => 'On what basis is NSF International H1 approval allocated?', 'answer' => 'Lubricants are made only from components that have been evaluated and approved by US FDA and declared safe for use in food processing preparations. The maximum concentration of a lubricant allowed in food in 10ppm. Manufacturers of Food Grade Lubricants described by FDA regulations must also follow Good Manufacturing Practise as a specific quality time.'],
        ['question' => 'What is the HACCP system of regulatory standards?', 'answer' => 'The Hazard Analysis and Critical Control Point System (HACCP) dates back to the 1960s when it was developed by the American Space Agency, NASA, in order to make risk-free food for astronauts. NASA identified points where contamination is likely to occur so that appropriate process controls could be implemented during production. That system is now federally mandated in the USA for use as a critical contamination prevention program under the food safety in seafood, meat and poultry processing facilities. The EU also employs the HACCP system to regulate all EU Companies involved in handling foodstuffs. In India, although the HACCP system is not mandatory, good manufacturing units have started adopting to HACCP Systems.'],
        ['question' => 'What is the legislation on the longevity of Food Grade Lubricants?', 'answer' => 'It should be noted that neither the FDA, NSF International nor the EU has made any statements with respect to food-grade lubricants in use. MOSIL recommends that, in the absence of relevant local legislation, the maximum amount of contamination of food itself by a Food Grade Lubricant should be 10ppm (10 mg/ kg) - the same limit set by the FDA for all non food compound, regardless of age. At concentrations below this limit MOSIL believes that MOSIL Food Grade Lubricants should not impart undesirable taste, odour or color to food, nor should they cause adverse health effects.']
    ],
    'General Lubrication' => [
        ['question' => 'What is the primary purpose of lubrication?', 'answer' => 'Lubrication reduces friction and wear between moving surfaces, helping to improve efficiency, reduce energy consumption, and extend equipment life.'],
        ['question' => 'What is the difference between oil and grease?', 'answer' => 'Oil is a fluid lubricant that flows freely, while grease is a semi-solid lubricant consisting of oil, thickener, and additives. Grease stays in place and is preferred where relubrication is difficult.'],
        ['question' => 'What are synthetic lubricants?', 'answer' => 'Synthetic lubricants are man-made fluids with superior performance characteristics such as high thermal stability, low pour points, and extended service life compared to mineral oils.'],
        ['question' => 'Can I mix different types of lubricants?', 'answer' => 'Mixing lubricants, especially greases with different thickeners, is generally not recommended as it may lead to separation, reduced performance, or equipment damage.'],
        ['question' => 'What are the key properties of a good lubricant?', 'answer' => 'Important properties include appropriate viscosity, thermal stability, oxidation resistance, wear protection, and compatibility with materials.'],
        ['question' => 'How do lubricants prevent corrosion?', 'answer' => 'Lubricants form a protective barrier that isolates metal surfaces from moisture and corrosive substances.'],
        ['question' => 'What are lubricant additives?', 'answer' => 'Additives are chemicals added to enhance lubricant properties, such as anti-wear agents, corrosion inhibitors, antioxidants, detergents, EP addtive, dispersant etc'],
        ['question' => 'How do I select the right lubricant for my machinery?', 'answer' => 'Consider factors such as operating temperature, load, speed, environment, and equipment manufacturer recommendations.'],
        ['question' => 'How often should I re-lubricate equipment?', 'answer' => 'Re-lubrication intervals depend on factors like operating conditions, speed, temperature, and manufacturer guidelines.'],
        ['question' => 'What is oil oxidation and how does it affect lubricant performance?', 'answer' => 'Oil oxidation is the chemical breakdown of base oil due to exposure to oxygen, heat, or contaminants. It leads to sludge formation, acidity, and reduced lubricant effectiveness.'],
        ['question' => 'What are the benefits of using high-temperature greases?', 'answer' => 'High-temperature greases maintain their stability, lubricity, and structure under elevated temperatures, preventing breakdown and protecting components.'],
        ['question' => 'Can lubricants expire?', 'answer' => 'Yes, lubricants can degrade over time due to oxidation or contamination. Always check the shelf life and storage conditions.'],
        ['question' => 'Why is lubricant cleanliness important?', 'answer' => 'Contaminants like dirt, water, or metal particles can accelerate wear and cause equipment failure.'],
        ['question' => 'What tests determine lubricant quality?', 'answer' => 'Common tests include viscosity, flash point, pour point, wear tests, oxidation stability, and dropping point (for grease), TAN, TBN, 4 Ball weld load, 4 Ball wear scar etc.'],
        ['question' => 'Can lubricants be used in underwater or submerged conditions?', 'answer' => 'Special waterproof or marine-grade lubricants are designed for submerged applications, offering resistance to water washout and corrosion.'],
        ['question' => 'What is tribology?', 'answer' => 'Tribology is the study of friction, wear, and lubrication between interacting surfaces in relative motion.'],
        ['question' => 'How does temperature affect lubricant performance?', 'answer' => 'High temperatures can lead to oxidation and thickening, while low temperatures can cause solidification or inadequate flow.'],
        ['question' => 'What are biodegradable lubricants?', 'answer' => 'These are environmentally friendly lubricants that break down naturally, used in applications where spillage into the environment is a concern.'],
        ['question' => 'Can using the wrong lubricant damage equipment?', 'answer' => 'Yes, incorrect lubricant choice can lead to excessive wear, overheating, or system failure.'],
        ['question' => 'Why is it important to follow OEM recommendations?', 'answer' => 'OEMs provide lubricant specifications that ensure optimal performance, warranty compliance, and reliability of the equipment.'],
        ['question' => 'Can lubricant be too clean?', 'answer' => 'Over-filtering can remove beneficial additives or degrade oil performance. Filtration should target contaminants, not essential components.'],
        ['question' => 'How do you check for lubricant contamination?', 'answer' => 'Through oil analysis, visual inspection, or sensor-based monitoring to detect water, particulates, fuel dilution, or metal wear.'],
        ['question' => 'What is the function of rust inhibitors in lubricants?', 'answer' => 'Rust inhibitors prevent oxidation and corrosion on metal surfaces, especially in humid or water-prone environments.'],
        ['question' => 'How does operating speed affect lubricant selection?', 'answer' => 'Higher speeds require lower viscosity oils or softer greases to minimise heat buildup, while slower speeds may benefit from higher viscosity or thicker greases.'],
        ['question' => 'Can improper lubricant disposal harm the environment?', 'answer' => 'Yes, improper disposal can contaminate soil and water. Always follow environmental regulations for lubricant recycling or disposal.'],
        ['question' => 'What are low-temperature lubricants and where are they used?', 'answer' => 'Low-temperature lubricants are designed to remain fluid and functional in freezing or sub-zero conditions, commonly used in cold storage, aerospace, or arctic operations.'],
        ['question' => 'How does humidity affect lubricants?', 'answer' => 'High humidity can promote moisture ingress, leading to corrosion, emulsification of oils, and compromised lubrication performance.'],
        ['question' => 'What is the difference between molybdenum disulphide and graphite as solid lubricants?', 'answer' => 'Molybdenum disulphide is better for high-load and vacuum applications, while graphite performs well in humid or high-temperature environments.'],
        ['question' => 'What is lubricant starvation?', 'answer' => 'Lubricant starvation occurs when insufficient lubricant reaches the friction surfaces, leading to increased wear or equipment failure.'],
        ['question' => 'How do anti-oxidants work in lubricants?', 'answer' => 'Antioxidants slow the degradation of the base oil by reacting with and neutralising free radicals formed during oxidation.'],
        ['question' => 'What is the function of base oil viscosity in gear oils?', 'answer' => 'Higher viscosity provides better load-carrying ability and film strength, important in high-load gear applications.'],
        ['question' => 'What is a lubricating film?', 'answer' => 'It’s a thin layer of lubricant separating two surfaces in motion, preventing direct contact and reducing wear.'],
        ['question' => 'What are the challenges of lubricating plastic components?', 'answer' => 'Compatibility must be checked, as some oils or greases can cause swelling, cracking, or embrittlement of plastics.'],
        ['question' => 'How is lubricant consumption calculated?', 'answer' => 'It is based on equipment type, operating conditions, lubricant type, and maintenance schedules, often guided by OEM formulas.'],
        ['question' => 'What is the difference between dynamic and static lubrication?', 'answer' => 'Dynamic lubrication occurs during motion; static lubrication protects surfaces during inactivity or storage.'],
        ['question' => 'What is thermal conductivity in lubricants?', 'answer' => 'It refers to the lubricant’s ability to transfer heat, contributing to temperature regulation in high-speed or heavily loaded components.'],
        ['question' => 'Can lubricants help reduce energy consumption?', 'answer' => 'Yes, by reducing friction and wear, lubricants improve efficiency and reduce power loss in machinery.'],
        ['question' => 'How often should lubricant systems be audited?', 'answer' => 'A full lubrication audit should be conducted annually or after major equipment changes to optimise reliability and cost-effectiveness.']
    ],
    'Physical and Chemical Property' => [
        ['question' => 'What is viscosity, and why does it matter?', 'answer' => 'Viscosity is a measure of a fluid\'s resistance to flow. The right viscosity ensures adequate film thickness for protection without excessive drag.'],
        ['question' => 'What is the Viscosity Index (VI)?', 'answer' => 'VI indicates how a lubricant\'s viscosity changes with temperature. A high VI means less change in viscosity, ensuring better protection over a wider temperature range.'],
        ['question' => 'What is boundary lubrication?', 'answer' => 'Boundary lubrication occurs when surfaces make contact due to insufficient lubricant film, often in start-stop or high-load conditions. Special additives help protect surfaces.'],
        ['question' => 'What is hydrodynamic lubrication?', 'answer' => 'This occurs when a full fluid film separates moving surfaces, significantly reducing friction and wear.'],
        ['question' => 'What is a dropping point in grease?', 'answer' => 'The dropping point is the temperature at which grease becomes fluid enough to drip, indicating its thermal limit.'],
        ['question' => 'How does water affect lubricants?', 'answer' => 'Water can cause emulsification, corrosion, and reduced lubrication effectiveness, especially in greases.'],
        ['question' => 'What is a relubrication interval and how is it calculated?', 'answer' => 'It is the recommended time between lubricant applications. It depends on speed, bearing size, temperature, and operating conditions, often guided by manufacturer formulas.'],
        ['question' => 'Why is compatibility important when changing lubricants?', 'answer' => 'Incompatible lubricants can cause thickener breakdown, separation, or chemical reactions that reduce performance.'],
        ['question' => 'What is the function of solid lubricants like graphite or molybdenum disulphide?', 'answer' => 'They reduce friction and wear under extreme pressure or high-temperature conditions where conventional lubricants fail.'],
        ['question' => 'What is the difference between NLGI grades in grease?', 'answer' => 'NLGI (National Lubricating Grease Institute) grades classify grease consistency. Lower numbers indicate softer grease, while higher numbers indicate firmer consistency.'],
        ['question' => 'What causes lubricant foaming and how can it be prevented?', 'answer' => 'Foaming is caused by air entrainment in the oil, often due to contamination, agitation, or unsuitable formulation. It can be reduced with anti-foam additives.'],
        ['question' => 'Why is base oil type important in lubricants?', 'answer' => 'Base oil determines the fundamental properties of a lubricant, such as thermal stability, oxidation resistance, and compatibility with additives.'],
        ['question' => 'What is EP (Extreme Pressure) lubricant?', 'answer' => 'EP lubricants contain additives that form a protective film under high load conditions to prevent metal-to-metal contact and wear.'],
        ['question' => 'What is the purpose of tackifiers in lubricants?', 'answer' => 'Tackifiers are additives used to increase the adhesive properties of lubricants, helping them stay in place during operation.'],
        ['question' => 'What is the function of corrosion inhibitors in lubricants?', 'answer' => 'They protect metal surfaces from oxidation and chemical attack, prolonging equipment life.'],
        ['question' => 'Are lubricants recyclable or reusable?', 'answer' => 'Used lubricants can be filtered and reconditioned in some cases. However, strict processes and quality checks are needed for reuse.'],
        ['question' => 'Why does grease leak from bearing seals?', 'answer' => 'Leakage can be due to over-greasing, incorrect grease type, faulty seals, or excessive pressure.'],
        ['question' => 'What is a lubricating oil\'s pour point?', 'answer' => 'The pour point is the lowest temperature at which an oil remains fluid and pourable, indicating its suitability for cold climates.'],
        ['question' => 'What are biodegradable greases used for?', 'answer' => 'These greases are used in environmentally sensitive areas like forestry, marine, or agriculture where accidental release may occur.'],
        ['question' => 'How does speed factor affect grease selection?', 'answer' => 'High-speed applications require low-consistency greases with high oxidation stability and minimal drag.'],
        ['question' => 'What is the shelf life of industrial grease?', 'answer' => 'Typically 3 to 5 years when stored in proper conditions — cool, dry, and away from contaminants.'],
        ['question' => 'What is the role of detergents and dispersants in lubricants?', 'answer' => 'They keep contaminants and deposits suspended, preventing sludge build-up and ensuring cleanliness.'],
        ['question' => 'Can a lubricant be too thick or too thin for an application?', 'answer' => 'Yes. Too thick may cause resistance and overheating; too thin may lead to inadequate film and wear.'],
        ['question' => 'What is fretting corrosion and can lubrication prevent it?', 'answer' => 'Fretting corrosion occurs from repeated contact or vibration between surfaces. Proper lubrication prevents metal contact and reduces wear.'],
        ['question' => 'What is the function of anti-wear additives in lubricants?', 'answer' => 'They create a protective layer on metal surfaces to minimise wear under normal operating conditions.'],
        ['question' => 'What is thermal stability in lubricants?', 'answer' => 'It is the lubricant’s ability to resist degradation at high temperatures, maintaining performance and structure.'],
        ['question' => 'Are coloured greases functionally different?', 'answer' => 'Colour is primarily for identification. However, some coloured greases may also include indicators for temperature or wear.'],
        ['question' => 'What is the role of calcium sulphonate in grease?', 'answer' => 'Calcium sulphonate thickeners provide excellent water resistance, mechanical stability, and load-carrying capacity, making them ideal for heavy-duty applications.'],
        ['question' => 'What is the significance of ISO viscosity grades?', 'answer' => 'ISO viscosity grades categorise industrial lubricants based on their kinematic viscosity at 40°C, helping users select the right fluid for specific applications.'],
        ['question' => 'What is the difference between oil-based and silicone-based lubricants?', 'answer' => 'Oil-based lubricants offer better mechanical lubrication, while silicone-based types provide water resistance, electrical insulation, and plastic compatibility.'],
        ['question' => 'What is a tacky lubricant and where is it used?', 'answer' => 'Tacky lubricants have adhesive additives to help them cling to surfaces, ideal for chains, open gears, and vertical applications.'],
        ['question' => 'Why do some lubricants have a strong odour?', 'answer' => 'Odour may result from specific base oils or additives; while not always harmful, strong smells can indicate contamination or degradation.'],
        ['question' => 'What are synthetic esters and where are they used?', 'answer' => 'Synthetic esters are high-performance base oils with excellent thermal and oxidative stability, often used in aviation, military, or biodegradable applications.'],
        ['question' => 'What are bio-based lubricants?', 'answer' => 'Lubricants derived from renewable biological sources such as vegetable oils, offering eco-friendliness and biodegradability.'],
        ['question' => 'How does shear stability affect grease performance?', 'answer' => 'Good shear stability ensures that grease maintains its consistency and structure under mechanical stress.'],
        ['question' => 'What is a lubricant’s flash point?', 'answer' => 'The flash point is the lowest temperature at which a lubricant emits enough vapour to ignite in air, indicating its flammability risk.'],
        ['question' => 'What are the signs of lubricant oxidation?', 'answer' => 'Darkening colour, sludge formation, increased viscosity, and acidic odour are typical signs of lubricant oxidation.'],
        ['question' => 'What is the role of polymers in grease?', 'answer' => 'Polymers can be used to enhance tackiness, water resistance, or film strength in greases.'],
        ['question' => 'What are environmentally acceptable lubricants (EALs)?', 'answer' => 'EALs meet environmental standards for toxicity, biodegradability, and bioaccumulation. They are required in sensitive applications like marine and hydropower.'],
        ['question' => 'How do you dispose of used lubricants responsibly?', 'answer' => 'Used lubricants should be collected in designated containers and sent to authorised recycling or disposal centres as per local regulations.'],
        ['question' => 'What are some signs of incompatible grease mixtures?', 'answer' => 'Grease thinning, hardening, separation, or unexpected performance drops are signs of incompatibility.']
    ]
];
?>

<!-- Hero Section -->
<section class="relative w-full h-[748px] md:h-[480px] overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/newsroom-banner.png"
            class="hidden md:block w-full h-full object-cover" alt="Newsroom">
        <img src="<?php echo SITE_URL; ?>/assets/images/banners/newsroom-banner-mb.png" alt="Newsroom"
            class="block md:hidden w-full h-full object-cover object-center" fetchpriority="high">
    </div>
    <div class="container relative z-20 flex items-end justify-start w-full h-full pb-4 md:pb-10">
        <h2
            class="text-white font-base font-normal text-[32px] md:text-[48px] leading-[120%] tracking-normal capitalize">
            Newsroom
        </h2>
    </div>
</section>


<section class="bg-main-green">
    <div class="container">
        <div class="md:flex items-center justify-start overflow-x-auto no-scrollbar gap-4 md:gap-0 hidden">
            <?php
            $navItems = [
                'events' => 'Event',
                'case-studies' => 'Case studies',
                'blogs' => 'Blogs',
                'glossary' => 'Glossary',
                'faqs' => 'FAQs'
            ];
            $first = true;
            foreach ($navItems as $id => $label) {
                ?>
                <a href="#<?php echo $id; ?>"
                    class="news-nav-link text-[#FFFFFF] text-center font-base font-normal text-[16px] md:text-[20px] leading-[120%] tracking-[0.01em] px-6 md:px-10 py-4 relative whitespace-nowrap transition-colors"
                    data-section="<?php echo $id; ?>">
                    <?php echo $label; ?>
                    <span
                        class="active-indicator absolute bottom-0 left-0 z-0 bg-primary w-full h-1 <?php echo $first ? '' : 'hidden'; ?>"></span>
                </a>
                <?php
                $first = false;
            }
            ?>
        </div>
    </div>
</section>



<section id="events" class="w-full bg-white">
    <div class="container py-6">
        <nav
            class="flex items-center breadcrumbs gap-1 text-[14px] md:text-[16px] leading-[150%] tracking-[0.015em] capitalize flex-wrap ">
            <a href="<?php echo SITE_URL; ?>/" class="text-[#A3A3A3] font-light">Home</a>

            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.5 4.16683L13.3333 10.0002L7.5 15.8335" stroke="#A3A3A3" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>
            <a href="#" class="text-[#575757] font-bold">Newsroom</a>
        </nav>
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                in the spotlight
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[var(--color-main-green)] font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Latest events</h2>
                <a href="<?php echo SITE_URL; ?>/events"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0">See
                    All</a>
            </div>
        </div>
        <div class="newsroom-events md:py-9.5 py-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 auto-rows-[240px]">

                <?php foreach ($latestBlogs as $item): ?>
                    <a href="<?php echo SITE_URL; ?>/blog/<?php echo $item['slug']; ?>" class="relative group overflow-hidden block
       <?php echo $item['is_featured'] ? 'md:col-span-2 md:row-span-2' : 'col-span-1'; ?>">

                        <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-115" style="background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.9) 100%), 
            url('<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $item['image']; ?>') no-repeat center/cover;">
                        </div>

                        <div class="relative h-full flex flex-col justify-end z-10 gap-2
            <?php echo $item['is_featured'] ? 'md:px-7.5 md:py-8.5' : 'md:px-3 md:py-4'; ?> px-4 py-4">

                            <span class="inline-block bg-[#F9DC6B] text-[#1A3B1B] font-base font-bold w-fit px-2 py-1
                                <?php
                                if ($item['is_featured']) {

                                    echo 'text-[10px] leading-[120%] tracking-[0.012em] uppercase 
                                        md:text-[12px] md:leading-[135%] md:tracking-normal md:normal-case';
                                } else {

                                    echo 'text-[10px] leading-[135%] tracking-[0.01em]';
                                }
                                ?>">
                                <?php echo $item['category_name']; ?>
                            </span>

                            <h3
                                class="text-[#FFFFFF] font-base font-bold capitalize 
                <?php echo $item['is_featured'] ? 'md:text-[24px] md:leading-[135%] md:tracking-[0.01em] text-[18px] leading-[140%] tracking-[0.015em]' : 'text-[14px]'; ?>">
                                <?php echo $item['title']; ?>
                            </h3>

                            <?php if (isset($item['created_at']) && $item['is_featured']): ?>
                                <p class="text-[#FFFFFF] font-base font-normal text-[14px] leading-[135%] tracking-[0.01em]">
                                    <?php echo date('F d, Y', strtotime($item['created_at'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div
                            class="absolute inset-0 bg-main-green/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<section id="case-studies" class="w-full bg-[#F5F5F5]">
    <div class="container pt-[30px] pb-[80px]">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                real world performance
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Case study
                </h2>
                <a href="<?php echo SITE_URL; ?>/case-studies"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0">
                    See all
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
            <?php
            $firstImage = !empty($caseStudies) ? $caseStudies[0]['image'] : '';
            ?>
            <div class="relative overflow-hidden md:h-full h-[300px] w-full aspect-[4/3] shrink-0">
                <img id="case-study-preview"
                    src="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $firstImage; ?>"
                    alt="Case Study Featured"
                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                    loading="lazy" />
            </div>

            <div class="flex flex-col gap-5">
                <?php
                if (!empty($caseStudies)):
                    foreach ($caseStudies as $index => $study):
                        $isActive = $index === 0;
                        ?>
                        <div class="case-study-item pt-5 pb-7 pl-8 pr-5.5 <?php echo $isActive ? 'bg-[#F4C300]' : 'bg-white hover:bg-[#F4C300]'; ?> rounded-br-[40px] relative group flex flex-col gap-2 overflow-hidden transition-colors cursor-pointer"
                            data-image="<?php echo SITE_URL; ?>/assets/uploads/case_studies/<?php echo $study['image']; ?>">

                            <span
                                class="absolute left-0 top-[20px] bottom-[20px] w-[2px] bg-[#1A3B1B] <?php echo $isActive ? 'scale-y-100' : 'scale-y-0'; ?> transition-transform duration-500 origin-top group-hover:scale-y-100 rounded-full"></span>

                            <div class="relative z-10 flex flex-col gap-2">


                                <h3
                                    class="text-[#3B3B3B] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                                    <?php echo $study['title']; ?>
                                </h3>
                                <span
                                    class="text-[#3B3B3B] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] opacity-80">
                                    <?php echo date('F d, Y', strtotime($study['created_at'])); ?>
                                </span>
                                <p class="text-[#3B3B3B] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em]">
                                    <?php
                                    $content = trim(preg_replace('/\s+/', ' ', strip_tags($study['introduction'])));
                                    echo mb_strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                    ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>


<section id="blogs" class="w-full">
    <div class="container pt-[24px] pb-[80px]">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Lubrication basics and beyond
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Blogs
                </h2>
                <a href="<?php echo SITE_URL; ?>/blog"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0">
                    See all
                </a>
            </div>
        </div>

        <div class="md:mt-8 mt-6 swiper newsSwiper">
            <div class="swiper-wrapper md:!grid md:grid-cols-3 md:gap-10">
                <?php foreach ($blogs as $blog) { ?>

                    <div class="swiper-slide grid! grid-rows-[auto_1fr_auto]!">

                        <div class="relative h-[240px] w-full rounded-[4px] overflow-hidden shrink-0 group/img">
                            <img src="<?php echo SITE_URL; ?>/assets/uploads/blog/<?php echo $blog['image']; ?>"
                                alt="Hero Image"
                                class="block h-full w-full object-center rounded-[4px] group-hover/img:scale-110 transition-transform duration-500"
                                loading="lazy">

                            <div
                                class="absolute bottom-2 left-2 px-2 py-1 bg-[var(--color-primary)] text-[var(--color-main-green)] font-bold text-[10px] leading-[135%] tracking-[0.01em]">
                                <h2><?php echo $blog['category_name']; ?></h2>
                            </div>
                        </div>

                        <div class="my-4 flex flex-col flex-1">
                            <h2
                                class="font-bold text-lg leading-[140%] tracking-[0.015em] capitalize text-[#3B3B3B] mb-3 line-clamp-2">
                                <?php echo $blog['title']; ?>
                            </h2>
                            <p
                                class="font-normal text-[16px] leading-[150%] tracking-[0.015em] text-[#757575] mb-2 line-clamp-3">
                                <?php
                                $content = trim(preg_replace('/\s+/', ' ', strip_tags($blog['content'])));
                                echo substr($content, 0, 500);
                                ?>
                            </p>
                            <p class="font-normal text-[14px] leading-[150%] tracking-[0.015em] text-[#A3A3A3] mt-auto">
                                <?php echo $blog['category_name']; ?> |
                                <?php echo date('F d, Y', strtotime($blog['created_at'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/blog/<?php echo $blog['slug']; ?>"
                            class="group/btn relative font-bold text-[18px] text-[#415C42] pb-2 inline-block w-fit capitalize hover:text-main-green">
                            Read <?php echo $blog['category_name']; ?>
                            <span
                                class="absolute bottom-0 left-0 w-full h-[2px] bg-[var(--color-primary)] transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-300 origin-left"></span>
                        </a>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section id="glossary" class="bg-main-green relative">
    <div class="absolute bottom-0 left-0">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_left_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
    <div class="container relative z-10 md:pt-[64px] md:pb-[86px] pt-6 pb-6">


        <div class="py-3.5">
            <p class="text-[#FAFAFA] font-normal text-xs leading-[120%] tracking-[0.015em] uppercase mb-1">
                Glossary
            </p>
            <div class="md:border-b md:border-primary pb-1">
                <h2 class="text-white font-normal text-2xl md:text-[40px] leading-[120%] tracking-normal capitalize">
                    Know the important terms
                </h2>
            </div>
        </div>
        <div class="md:mt-8 mt-6 grid grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-[#415C42] px-4 flex flex-col">
                <h6 class="text-[#FFFFFF] font-base font-normal text-[64px] leading-[120%]">
                    A
                </h6>
                <p class="text-[#FFFFFF] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] mb-2">
                    Lubrications terms as per letter A

                </p>
                <p class="text-[#F5F5F5] font-base font-normal text-[12px] leading-[150%] tracking-[0.015em] mb-6">
                    You can find more such terms on the glossary page

                </p>
                <a href="<?php echo SITE_URL; ?>/glossary"
                    class="text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize">
                    Read all terms
                </a>
            </div>
            <?php foreach ($glossary['items'] as $index => $item) { ?>
                <div
                    class="glossary-card bg-[#415C42] px-4 py-6 rounded-[4px] flex flex-col gap-4 justify-start items-start h-full border border-transparent hover:bg-primary transition-all ease-in-out duration-300 group">

                    <h4
                        class="glossary-title text-[#FFFFFF] font-base font-bold text-[18px] leading-[140%] tracking-[0.015em] capitalize group-hover:text-main-green transition-colors">
                        <?php echo htmlspecialchars($item['keyword']); ?>
                    </h4>

                    <div
                        class="js-explanation text-[#FFFFFF] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] line-clamp-4 group-hover:text-[#757575] transition-colors">
                        <?php echo htmlspecialchars($item['explanation']); ?>
                    </div>

                    <button type="button"
                        class="read-more-btn hidden text-[#FFFFFF] font-base font-bold text-[16px] leading-[150%] tracking-[0.015em] capitalize transition-colors mt-auto cursor-pointer group-hover:text-main-green"
                        data-keyword="<?php echo htmlspecialchars($item['keyword']); ?>"
                        data-full-description="<?php echo htmlspecialchars($item['explanation']); ?>">
                        Read more
                    </button>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="absolute top-0 right-0 h-full">
        <img src="<?php echo SITE_URL; ?>/assets/images/ui/bg_lubi_drop_right_light.png" alt="lubrication decision"
            class="block h-full w-full object-cover object-center" loading="lazy">
    </div>
</section>






<section id="faqs" class="w-full">
    <div class="container py-[80px]">
        <div class="py-3.5">
            <span
                class="text-[#666666] font-base font-normal text-[10px] leading-[120%] tracking-[0.015em] uppercase md:text-[12px] md:tracking-[0.015em] md:overflow-hidden md:text-ellipsis md:whitespace-nowrap mb-1">
                Faqs
            </span>
            <div class="border-b border-primary pb-1 flex md:items-center items-end justify-between">
                <h2
                    class="text-[#1A3B1B] font-base font-normal text-[24px] leading-[135%] tracking-[0.015em] capitalize md:text-[40px] md:leading-[120%] md:tracking-normal md:overflow-hidden md:text-ellipsis md:whitespace-nowrap">
                    Answer to your questions
                </h2>
                <a href="<?php echo SITE_URL; ?>/faqs"
                    class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] md:text-[24px] md:font-bold md:leading-[120%] md:tracking-[0.01em] shrink-0">
                    See all
                </a>
            </div>
        </div>

        <div class="md:mt-10 mt-6">

            <?php
            $faqLoopIndex = 0;
            foreach ($faqs as $categoryName => $questions):
                // Only show first 2 questions as preview
                $previewQuestions = array_slice($questions, 0, 2);
                $isOpen = ($faqLoopIndex === 0) ? 'open' : '';
                ?>
                <details class="group border-b-2 border-[#EBEBEB] overflow-hidden py-3 px-5 md:py-6" <?php echo $isOpen; ?>>

                    <summary class="flex justify-between items-center cursor-pointer list-none outline-none">
                        <span
                            class="text-[#1A3B1B] font-base font-normal text-[18px] leading-[140%] capitalize md:text-[24px] md:leading-[135%] md:tracking-[0.015em] transition-transform duration-300">
                            <?php echo $categoryName; ?>
                        </span>

                        <div class="relative w-6 h-6 flex items-center justify-center">
                            <span class="absolute md:w-5 w-4 h-[2px] bg-[#1A3B1B] rounded-full"></span>
                            <span
                                class="absolute w-[2px] md:h-5 h-4 bg-[#1A3B1B] rounded-full transition-transform duration-500 ease-in-out group-open:rotate-90 group-open:opacity-0"></span>
                        </div>
                    </summary>

                    <div class="flex flex-col gap-6 mt-6">

                        <ul class="flex flex-col gap-4">
                            <?php foreach ($previewQuestions as $qa): ?>
                                <li class="border-b-2 border-[#DEDEDE] pb-3 flex flex-col gap-3">
                                    <p
                                        class="text-[#757575] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] md:text-[#3B3B3B] md:text-[18px] md:leading-[140%] md:tracking-normal">
                                        <?php echo $qa['question']; ?>
                                    </p>
                                    <p
                                        class="text-[#757575] font-base font-normal text-[14px] leading-[150%] tracking-[0.015em] md:text-[16px] md:tracking-[0.015em]">
                                        <?php echo $qa['answer']; ?>
                                    </p>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="flex justify-center">
                            <a href="<?php echo SITE_URL; ?>/faqs"
                                class="px-8 py-2 border border-[#1A3B1B] text-[#1A3B1B] rounded-full hover:bg-[#1A3B1B] hover:text-white transition-all duration-300 font-base text-[14px]">
                                Read More
                            </a>
                        </div>

                    </div>
                </details>
                <?php
                $faqLoopIndex++;
            endforeach;
            ?>

        </div>
    </div>
</section>


<section class="w-full bg-white">
    <div class="container py-20">
        <div class="flex flex-col md:flex-row items-stretch overflow-hidden">

            <div class="relative w-full md:w-[437px] h-[280px] shrink-0">
                <img src="<?php echo SITE_URL; ?>/assets/images/ui/connect.jpg" alt="Stay connected"
                    class="w-full h-full object-cover" />
            </div>

            <div class="p-[50px] bg-[#F4C300] flex flex-col justify-center flex-grow">

                <h2 class="text-[#1A3B1B] font-base font-normal text-[32px] leading-[120%] capitalize mb-4">
                    Stay connected
                </h2>

                <p class="text-[#3B3B3B] font-base font-normal text-[16px] leading-[150%] tracking-[0.015em] mb-6">
                    Get MOSIL press releases & newsletters in your inbox, and reach our media relations team for
                    interviews or info – stay connected to our experts worldwide.
                </p>

                <div class="flex flex-wrap items-center gap-4 justify-start">
                    <button type="button"
                        class="py-3 px-6 bg-[#1A3B1B] text-white text-center font-base font-normal text-[16px] leading-[150%] rounded-full border border-[#1A3B1B] cursor-pointer button-hover-vertical">
                        Contact the team
                    </button>

                    <button type="button"
                        class="py-3 px-6 text-[#1A3B1B] border border-[#1A3B1B] text-center font-base font-normal text-[16px] leading-[150%] rounded-full cursor-pointer button-hover-vertical">
                        Subscribe
                    </button>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<!-- Modal -->
<div id="glossary-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full relative">
            <div class="bg-white px-12.5 py-11 rounded-[4px]">
                <div class="sm:flex sm:items-start">
                    <div class="text-left w-full">
                        <h3 class="text-[#1A3B1B] font-base font-bold text-[24px] leading-[135%] capitalize mb-4"
                            id="glossary-modal-title">Terms</h3>
                        <div class="mt-4">
                            <p class="text-[#666666] font-base font-normal text-[18px] leading-[140%] tracking-[0.015em] whitespace-pre-line"
                                id="glossary-modal-body">Description
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute right-4 top-4">
                <button type="button" id="glossary-modal-close" class="w-8 h-8 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path d="M8 24L24 8M8 8L24 24" stroke="#A3A3A3" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        const cards = document.querySelectorAll('.glossary-card');
        const modal = document.getElementById("glossary-modal");
        const modalTitle = document.getElementById("glossary-modal-title");
        const modalBody = document.getElementById("glossary-modal-body");
        const modalClose = document.getElementById("glossary-modal-close");

        const modalTitleTarget = document.querySelector("#glossary-modal-title"); // Using class selector if id is problematic or ensuring correct selection

        cards.forEach(card => {
            const explanation = card.querySelector('.js-explanation');
            const btn = card.querySelector('.read-more-btn');

            // Check if the actual text height is greater than the visible container height
            if (explanation.scrollHeight > explanation.clientHeight) {
                btn.classList.remove('hidden');
            }

            // Add click event for opening modal
            btn.addEventListener('click', () => {
                const keyword = btn.getAttribute('data-keyword');
                const fullDesc = btn.getAttribute('data-full-description');

                // Assuming the title element has id="glossary-modal-title" (fixed in HTML below)
                if (document.getElementById('glossary-modal-title')) {
                    document.getElementById('glossary-modal-title').textContent = keyword;
                }
                modalBody.textContent = fullDesc;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            });
        });

        // Close Modal Logic
        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        // Close on click outside
        window.addEventListener('click', (e) => {
            if (e.target === modal.querySelector('.fixed.inset-0.transition-opacity')) {
                closeModal();
            }
        });

        const links = document.querySelectorAll('.news-nav-link');
        const sections = ['events', 'case-studies', 'blogs', 'glossary', 'faqs'].map(id => document.getElementById(id));

        // Smooth Scroll
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    // Offset for header if needed, defaulting to a bit of padding
                    const yOffset = -20;
                    const y = targetSection.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });

                    // Manually set active state immediately for better UX
                    updateActiveLink(targetId);
                }
            });
        });

        // Toggle Active State helper
        function updateActiveLink(id) {
            document.querySelectorAll('.news-nav-link .active-indicator').forEach(el => el.classList.add('hidden'));
            const activeLink = document.querySelector(`.news-nav-link[href="#${id}"] .active-indicator`);
            if (activeLink) activeLink.classList.remove('hidden');
        }

        // Scroll Spy with Intersection Observer
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -60% 0px', // Active when section is in the middle of viewport
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateActiveLink(entry.target.id);
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            if (section) observer.observe(section);
        });

        // Case Study Hover Logic
        const caseStudyItems = document.querySelectorAll('.case-study-item');
        const previewImage = document.getElementById('case-study-preview');

        caseStudyItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                // Update Image
                const newImage = item.getAttribute('data-image');
                if (newImage && previewImage) {
                    previewImage.src = newImage;
                }

                // Update Active Styles (Optional: remove active class from others if needed for strict single-active state)
                caseStudyItems.forEach(el => {
                    const indicator = el.querySelector('span.absolute');
                    if (el === item) {
                        el.classList.remove('bg-white');
                        el.classList.add('bg-[#F4C300]');
                        if (indicator) indicator.classList.remove('scale-y-0');
                        if (indicator) indicator.classList.add('scale-y-100');
                    } else {
                        el.classList.add('bg-white');
                        el.classList.remove('bg-[#F4C300]');
                        if (indicator) indicator.classList.add('scale-y-0');
                        if (indicator) indicator.classList.remove('scale-y-100');
                    }
                });
            });
        });
    });
</script>