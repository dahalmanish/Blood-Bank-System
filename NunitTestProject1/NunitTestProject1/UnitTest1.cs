using NUnit.Framework;
using OpenQA.Selenium;
using OpenQA.Selenium.Chrome;
using OpenQA.Selenium.Support.UI;

namespace NunitTestProject1
{
    public class Tests
    {
        IWebDriver webDriver;

        [OneTimeSetUp]
        public void Setup()
        {
            webDriver = new ChromeDriver(".");
        }

        [Test]
        public void Test1()
        {
            webDriver.Url = @"http://localhost/BBDMS-Project-PHP/contact.php";
            IWebElement name = webDriver.FindElement(By.Id("name"));
            name.SendKeys("Aashik g");

            IWebElement email = webDriver.FindElement(By.Id("email"));
            email.SendKeys("Aashikg@gmail.com");

            IWebElement phone = webDriver.FindElement(By.Id("phone"));
            phone.SendKeys("1234567891"); // Assuming this is the phone number format

            IWebElement message = webDriver.FindElement(By.Id("message"));
            message.SendKeys("This is a test message");

            IWebElement sendButton = webDriver.FindElement(By.CssSelector("input[type='submit']"));
            sendButton.Click();

            // Assuming there's a confirmation message or redirection after form submission, add assertions as needed

            Assert.Pass();
        }

        [OneTimeTearDown]
        public void CloseTest()
        {
            //webDriver.Close();
        }
    }
}
