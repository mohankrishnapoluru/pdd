<style>
    /* Redesigned Footer Styles */
    footer {
        background-color: #1a1a1a; /* Darker background for modern feel */
        color: #ffffff;
        padding: 10px; /* Reduced padding */
        font-family: 'Arial', sans-serif;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px; /* Reduced gap between sections */
        align-items: start;
        text-align: left;
    }

    .footer-section h4 {
        font-size: 16px; /* Reduced font size */
        margin-bottom: 8px;
        color: #3498db; 
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-section p {
        font-size: 12px; /* Reduced font size */
        line-height: 1.6;
        color: #cccccc;
    }

    .footer-section a {
        display: block;
        font-size: 12px; /* Reduced font size */
        color: #dddddd;
        margin: 5px 0;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-section a:hover {
        color: #3498db;
    }

    .footer-social {
        display: flex;
        gap: 8px; /* Reduced gap between social media links */
    }

    .footer-social a {
        font-size: 14px; /* Reduced font size for social media links */
        color: #dddddd;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-social a:hover {
        color: #3498db;
    }

   

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .footer-social {
            justify-content: center;
        }
    }
</style>

<footer>
        <p>&copy; 2024 Mediplus Clinic | All Rights Reserved</p>
        
</footer>
