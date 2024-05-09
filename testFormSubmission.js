const { Builder, By, until } = require('selenium-webdriver');
const chrome = require('selenium-webdriver/chrome');

(async function testContactForm() {
    // Set up options for the Chrome browser
    const options = new chrome.Options();
    options.addArguments('--start-maximized'); // Start browser maximized

    // Create a new instance of the Chrome browser
    const driver = await new Builder()
        .forBrowser('chrome')
        .setChromeOptions(options)
        .build();

    try {
        // Define test data
        const formData = {
            name: 'John Doe',
            email: 'john.doe@example.com',
            contactNumber: '1234567890',
            message: 'This is a test message.',
        };

        // Navigate to the contact form page
        await driver.get('http://localhost/BBDMS-Project-PHP/contact.php');

        // Wait for the form fields to be located and visible
        const nameInput = await driver.wait(until.elementLocated(By.name('fullname')), 20000);
        const emailInput = await driver.wait(until.elementLocated(By.name('email')), 20000);
        const contactNoInput = await driver.wait(until.elementLocated(By.name('contactno')), 20000);
        const messageInput = await driver.wait(until.elementLocated(By.name('message')), 20000);
        const sendButton = await driver.wait(until.elementLocated(By.name('send')), 20000);

        // Ensure elements are visible and enabled
        await driver.wait(until.elementIsVisible(nameInput), 10000);
        await driver.wait(until.elementIsVisible(emailInput), 10000);
        await driver.wait(until.elementIsVisible(contactNoInput), 10000);
        await driver.wait(until.elementIsVisible(messageInput), 10000);
        await driver.wait(until.elementIsVisible(sendButton), 10000);

        // Fill out the form
        await nameInput.sendKeys(formData.name);
        await emailInput.sendKeys(formData.email);
        await contactNoInput.sendKeys(formData.contactNumber);
        await messageInput.sendKeys(formData.message);

        // Submit the form
        await sendButton.click();

        // Wait for an alert or confirmation message
        await driver.wait(until.alertIsPresent(), 10000);
        const alert = await driver.switchTo().alert();
        const alertText = await alert.getText();
        await alert.accept(); // Accept the alert

        // Verify the success message
        if (alertText.includes('Query Sent.')) {
            console.log('Contact form test passed!');
        } else {
            console.log('Contact form test failed!');
        }

    } catch (error) {
        console.error('Test failed with error:', error);
    } finally {
        // Quit the browser session
        await driver.quit();
    }
})();
