<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLM Application Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header .logo {
            width: 60px;
            height: auto;
        }
        .header .title {
            text-align: center;
            flex-grow: 1;
        }
        .header .title h1, .header .title h2, .header .title h3 {
            margin: 0;
            padding: 0;
        }
        .header .photo-placeholder {
            width: 1.5in;
            height: 1.5in;
            border: 1px solid black;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 10px;
            text-align: center;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section td {
            border: 1px solid black;
            padding: 5px;
        }
        .consent-form {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('../assets/image/school.png') }}" alt="Logo" class="logo">
        <div class="title">
            <h1>Pamantasan ng Lungsod ng Maynila</h1>
            <h2>University of the City of Manila</h2>
            <h3>PLM Application Form</h3>
        </div>
        <div class="photo-placeholder">
            <span>Paste 1.5 x 1.5<br>ID Picture Here</span>
        </div>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td colspan="2">APPLICANT ID:</td>
            </tr>
            <tr>
                <td colspan="4"><strong>PERSONAL INFORMATION:</strong></td>
            </tr>
            <tr>
                <td>FULL NAME: First Name</td>
                <td>MIDDLE NAME:</td>
                <td>LAST NAME:</td>
                <td>EXTENSION NAME:</td>
            </tr>
            <tr>
                <td>ADDRESS:</td>
                <td>PROVINCE:</td>
                <td>REGION:</td>
                <td></td>
            </tr>
            <tr>
                <td>BIRTH DATE:</td>
                <td>BIRTH PLACE:</td>
                <td>GENDER:</td>
                <td></td>
            </tr>
            <tr>
                <td>CONTACT NO:</td>
                <td>EMAIL ADDRESS:</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td colspan="3"><strong>FAMILY INFORMATION:</strong></td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td>Father</td>
                <td>Mother</td>
            </tr>
            <tr>
                <td>Address</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Contact No.</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Occupation</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Family Monthly Income</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td colspan="2"><strong>SCHOOL INFORMATION:</strong></td>
            </tr>
            <tr>
                <td>LRN:</td>
                <td></td>
            </tr>
            <tr>
                <td>STRAND:</td>
                <td></td>
            </tr>
            <tr>
                <td>SCHOOL NAME:</td>
                <td></td>
            </tr>
            <tr>
                <td>SCHOOL ADDRESS:</td>
                <td></td>
            </tr>
            <tr>
                <td>SCHOOL EMAIL ADDRESS:</td>
                <td></td>
            </tr>
            <tr>
                <td>GENERAL WEIGHTED AVERAGE (GWA):</td>
                <td>Grade 11:</td>
            </tr>
            <tr>
                <td>Program Choice 1:</td>
                <td></td>
            </tr>
            <tr>
                <td>Program Choice 2:</td>
                <td></td>
            </tr>
            <tr>
                <td>Program Choice 3:</td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="consent-form">
        <p><strong>DATA PRIVACY CONSENT FORM</strong></p>
        <p>The Pamantasan ng Lungsod ng Maynila (PLM) and its duly authorized representatives are duty-bound and obligated under Republic Act No. 10173 (Data Privacy Act of 2012) and its Implementing Rules and Regulations (IRR), and other data privacy rules, to protect the personal and sensitive personal information that PLM collects, possesses, and retains upon your enrollment and during your stay in the University.</p>
        <p>Personal and sensitive personal information includes any information about your identity, academics, or any document containing your identity. This includes, but is not limited to, your name, address, landline/mobile number, email address, names of your parents or guardians, date of birth, academic information such as grades and attendance, and other information necessary for basic administration and instruction. By consenting to this Data Privacy Consent Form, you agree that:</p>
        <p>1. You authorize the University to collect, retain and process information relating to your PLMAT application for purposes of admission to the University and for your subsequent enrollment should you eventually qualify to be admitted in PLM. PLM shall also collect, retain and process your personal and sensitive personal information to pursue its legitimate interests as an educational and government institution.</p>
        <p>2. You expressly authorize PLM to verify, validate and authenticate the information and documents that you submitted with relevant government and non-government sources and third parties, for purposes of your admission, enrollment, and other legitimate transactions in PLM.</p>
        <p>3. You authorize PLM to share your personal and sensitive personal information with its affiliated or partner organizations as part of its contractual obligations, or with government agencies such as, but not exclusive to, the Commission on Higher Education (CHED), UniFAST, and the City Government of Manila, pursuant to law or legal processes.</p>
        <p>4. You understand that photocopies or electronic copies of the personal documents that you submitted in relation to your application for admission will either be returned to you or properly disposed of by PLM if you are not accepted for admission or should you decide not to pursue your application. On the other hand, once accepted and upon enrollment, personal documents will be retained by PLM for legitimate purposes.</p>
    </div>
</body>
</html>