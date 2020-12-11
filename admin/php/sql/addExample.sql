DELETE FROM `product` WHERE `image_url` LIKE 'example/%';

INSERT INTO `product` 
(
`name`, 
`short_description`, 
`long_description`, 
`price`, 
`discount`, 
`quantity`, 
`image_url`
)
VALUES
(
'SAMSUNG 970 EVO M.2 2280 500GB PCIe Gen3. X4, NVMe 1.3 V-NAND 3-bit MLC Internal Solid State Drive (SSD) MZ-V7E500BW',
'<ul><li>M.2 2280 </li><li>500GB </li><li>PCIe Gen3. X4, NVMe 1.3</li></ul>',
'example/e1.html',
119.99,
20.00,
1000,
'example/e1.jpg'
),
(
'
ASUS AC5300 Wi-Fi Tri-band Gigabit Wireless Router with 4x4 MU-MIMO, 4 x LAN Ports, AiProtection Network Security and WTFast Game Accelerator, AiMesh Whole Home Wi-Fi System Compatible (RT-AC5300)',
'<ul><li>Tri band (Dual 5 GHz, single 2; 4 GHz) with the latest 802.11AC 4x4 technology for maximum throughput (5334 Mbps) and coverage (up to 5,000 square feet)
</li><li>Mu memo technology enables multiple compatible clients to connect at each client’s respective maximum speed; Supports every operating System, including Windows, Mac OS and Linux
</li><li>Built in ACCESS to Waist gamers private network (GPN) of route optimized servers ensures low, stable ping times for gaming; Printer Server; Multifunctional printer support (Windows only)
</li><li>A protection powered by Trend Micro provides multi stage protection from vulnerability detection to protecting sensitive data
</li><li>ASUS Smart Connect delivers consistent bandwidth by dynamically switching devices between 2; 4 and 5 GHz bands based on speed, load and signal strength; NOTE: Refer the user manual; WAN Connection Type: Internet connection type: Automatic IP, Static IP, Pepo(MPPE supported), PPTP, L2TP.DC Output: 19 Volt with max; 3.42 A current</li></ul>',
'example/e2.html',
399.99,
150.00,
1000,
'example/e2.jpg'
),
(
'WD Black 6TB Performance Desktop Hard Disk Drive - 7200 RPM SATA 6Gb/s 256MB Cache 3.5 Inch - WD6003FZBX',
'<ul><li>Desktop performance hard drive
</li><li>Performance storage available in up to 6TB capacities
</li><li>2X DRAM cache up to 256MB for faster read operations 
</li><li>Designed for creative professionals, gamers and system builders
</li><li>WDs StableTrac and Dynamic Cache Technology increase reliability and optimize performance
</li><li>Industry-leading 5-year limited warranty</li></ul>',
'example/e3.html',
339.00,
120.0,
25,
'example/e3.jpg'
),
(
'G.SKILL TridentZ RGB Series 32GB (2 x 16GB) 288-Pin DDR4 SDRAM DDR4 3600 (PC4 28800) Intel XMP 2.0 Desktop Memory Model F4-3600C16D-32GTZRC',
'<ul><li>DDR4 3600 (PC4 28800) 
</li><li>Timing 16-19-19-39 
</li><li>CAS Latency 16 
</li><li>Voltage 1.35V</li></ul>',
'example/e4.html',
248.99,
29,
10,
'example/e4.jpg'
),
(
'CORSAIR Vengeance LPX 32GB (2 x 16GB) 288-Pin DDR4 SDRAM DDR4 3200 (PC4 25600) Intel XMP 2.0 Desktop Memory Model CMK32GX4M2B3200C16',
'<ul><li>DDR4 3200 (PC4 25600) 
</li><li>Timing 16-18-18-36 
</li><li>CAS Latency 16 
</li><li>Voltage 1.35V</li></ul>',
'example/e5.html',
182.99,
28.00,
0,
'example/e5.jpg'
),
(
'BenQ GW2480 24" Full HD 1920 x 1080 VGA HDMI DisplayPort Flicker-Free Technology Built-in Speakers Slim Bezel Design LED Backlit IPS Monitor',
'<ul><li>1920 x 1080 Full HD Resolution</li><li>VGA, HDMI (1.4), DisplayPort Video Inputs</li><li>HDCP (1.4) Support</li><li>20,000,000:1 Dynamic Contrast Ratio</li><li>16.7 Million Color Support</li><li>Flicker-Free Technology</li><li>Low Blue Light Filter</li><li>Built-in Speakers</li><li>Tilt Adjustable</li><li>VESA Mount Compatible</li></ul>',
'example/e6.html',
159.99,
0.00,
1000,
'example/e6.jpg'
),
(
'Skytech Archangel - Ryzen 5 3600, GeForce GTX 1660, 500 GB SSD, 16 GB DDR4, RGB Fans, Windows 10 Home, 802.11AC Wi-Fi - Gaming Desktop (ST-Arch3.0-0054-NE)',
'<ul><li>AMD Ryzen 5 3600 6-Core 12-Thread 3.6 GHz (4.2 GHz Max Boost) CPU, 500 GB SSD - Up to 30x faster than traditional HDD, B450 Motherboard</li><li>GeForce GTX 1660 6 GB GDDR5 Graphics Card (Brand May Varies), 16 GB DDR4 3000 MHz Gaming Memory with Heat Spreaders, Windows 10 Home 64-bit, AMD High Performance Wraith Cooler</li><li>802.11AC Wi-Fi, No Bloatware, 1 x DVI, 1 x HDMI, 1 x Display Port, HD Audio and Mic, Free Gaming Keyboard and Mouse, 2 x USB 3.0, 2 x USB 2.0, 4 x USB 3.2 Gen 1</li><li>3 x RGB RING Fans for Maximum Air Flow, Powered by 80 Plus Certified 500 Watt Power Supply, Skytech Archangel Gaming Case with Tempered Glass - White</li></ul>',
'example/e7.html',
1499.99,
350,
100,
'example/e7.jpg'
),
(
'AZZA PSAZ-550W 550W Intel ATX12V 80 PLUS BRONZE Certified Power Supply',
'<ul><li>Intel ATX12V 
</li><li>80 PLUS BRONZE Certified 
</li><li>100 - 240 V 47 - 63 Hz 
</li><li>+3.3V@20A, +5V@20A, +12V@41A, -12V@0.4A, +5VSB@2.5A</li></ul>',
'example/e8.html',
79.99,
30.00,
100,
'example/e8.jpg'
),
(
'ASUS Prime Z390-A LGA 1151 (300 Series) Intel Z390 SATA 6Gb/s ATX Intel Motherboard',
'<ul><li>Designed for 9th and 8th generation Intel Core processors to maximize connectivity and speed with M.2, USB 3.1 Gen2 and ASUS OptiMem II for better DRAM overclocking stability </li><li>Revamped 5-Way Optimization with 1-click OC, that has the intelligence to overclock a CPU based on smart prediction and thermal telemetry </li><li>5X Protection III Hardware-level safeguards with SafeSlot Core, LANGuard and Overvoltage Protection provide component longevity and reliability while FanXpert 4 with AIO Pump Header delivers advanced fan control for dynamic system cooling</li><li>Unique SafeSlot Core fortified PCIe slots prevent damage caused by heavyweight GPUs</li><li>Realtek ALC S1220A 8-Channel High Definition Audio CODEC featuring Crystal Sound 3</li><li>AURA Sync RGB</li></ul>',
'example/e9.html',
169.99,
30.00,
84,
'example/e9.jpg'
),
(
'Google GA00781-CA Nest Mini Gen2 Home Automation - Charcoal',
'<ul><li>Far-Field Voice Recognition Technology</li><li>Multi-User Capability</li><li>Dual-Band Wi-Fi Connectivity</li><li>Wireless Audio Streaming via Wi-Fi</li></ul>',
'example/e10.html',
69.00,
34.00,
2048,
'example/e10.jpg'
);

UPDATE `product` SET `status`='featured' WHERE `image_url` LIKE 'example/%';