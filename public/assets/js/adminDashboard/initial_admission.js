// Progress Chart
const dataProgress = {
    labels: ['Approved', 'Pending', 'Resubmission'],
    datasets: [{
        label: 'Application Status',
        data: [12, 19, 3],
        borderWidth: 1
    }]
}

const optionProgress = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
}

const configProgress = {
    type: 'bar',
    data: dataProgress,
    options: optionProgress,
    plugins: [ChartDataLabels]
}

const progressChart = new Chart(
    document.getElementById('progressChart'),
    configProgress
);

// Gender Chart
const dataGender = {
    labels: ['Male', 'Female'],
    datasets: [{
        label: 'Gender Count',
        data: [male, female],
        borderWidth: 1
    }]
}

const optionGender = {
    plugins: {
        datalabels: {
            formatter: (value, ctx) => {
                const dataset = ctx.chart.data.datasets[0];
                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return percentage + '%';
            },
            font: {
                size: 16,
                weight: 'bold',
            },
            color: '#000000'
        }
    }
}

const configGender = {
    type: 'pie',
    data: dataGender,
    options: optionGender,
    plugins: [ChartDataLabels]
}

const genderChart = new Chart(
    document.getElementById('genderChart'),
    configGender
);

// Applicant Chart
const dataApplicant = {
    labels: ['SHS', 'ALS', 'Old Curriculum', 'Transferee'],
    datasets: [{
        label: 'Number of Applicants',
        data: [count.SHS, count.ALS, count.OLD, count.TRANSFER],
        borderWidth: 1
    }]
}

const optionApplicant = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
}

const configApplicant = {
    type: 'bar',
    data: dataApplicant,
    options: optionApplicant,
    plugins: [ChartDataLabels]
}

const applicantChart = new Chart(
    document.getElementById('applicantChart'),
    configApplicant
);

// Region Chart
const dataRegion = {
    labels: ['NCR', 'CAR', 'I', 'II', 'III', 'IV-A', 'MIMAROPA', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'BARMM'],
    datasets: [{
        label: 'Number of Applicants',
        data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16 ,17],
        borderWidth: 1
    }]
}

const optionRegion = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
}

const configRegion = {
    type: 'bar',
    data: dataRegion,
    options: optionRegion,
    plugins: [ChartDataLabels]
}

const regionChart = new Chart(
    document.getElementById('regionChart'),
    configRegion
);

// Manila to Non-Manila Ratio Chart
const dataManilaRatio = {
    labels: ['Manilenyo', 'Non-Manilenyo'],
    datasets: [{
        label: 'Manilenyo to Non-Manilenyo Ratio',
        data: [50, 23],
        borderWidth: 1
    }]
}

const optionManilaRatio = {
    plugins: {
        datalabels: {
            formatter: (value, ctx) => {
                const dataset = ctx.chart.data.datasets[0];
                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return percentage + '%';
            },
            font: {
                size: 16,
                weight: 'bold',
            },
            color: '#000000'
        }
    }
}

const configManilaRatio = {
    type: 'pie',
    data: dataManilaRatio,
    options: optionManilaRatio,
    plugins: [ChartDataLabels]
}

const manilaRatioChart = new Chart(
    document.getElementById('manilaRatioChart'),
    configManilaRatio
);

// Strand Chart
const dataStrand = {
    labels: ['STEM', 'ABM', 'HUMSS', 'GAS', 'TVL', 'SPORTS', 'ARTS', 'TECHVOC'],
    datasets: [{
        label: 'Number of Applicants',
        data: [1, 2, 3, 4, 5, 6, 7, 8],
        borderWidth: 1
    }]
}

const optionStrand = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
}

const configStrand = {
    type: 'bar',
    data: dataStrand,
    options: optionStrand,
    plugins: [ChartDataLabels]
}

const strandChart = new Chart(
    document.getElementById('strandChart'),
    configStrand
);

// Manila Public Private Ratio Chart
const dataManilaSchool = {
    labels: ['Public', 'Private'],
    datasets: [{
        label: 'Public to Private Ratio',
        data: [50, 23],
        borderWidth: 1
    }]
}

const optionManilaSchool = {
    plugins: {
        datalabels: {
            formatter: (value, ctx) => {
                const dataset = ctx.chart.data.datasets[0];
                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return percentage + '%';
            },
            font: {
                size: 16,
                weight: 'bold',
            },
            color: '#000000'
        }
    }
}

const configManilaSchool = {
    type: 'pie',
    data: dataManilaSchool,
    options: optionManilaSchool,
    plugins: [ChartDataLabels]
}

const manilaSchoolChart = new Chart(
    document.getElementById('manilaSchoolChart'),
    configManilaSchool
);

// Other Public Private Ratio Chart
const dataOtherSchool = {
    labels: ['Public', 'Private'],
    datasets: [{
        label: 'Public to Private Ratio',
        data: [50, 23],
        borderWidth: 1
    }]
}

const optionOtherSchool = {
    plugins: {
        datalabels: {
            formatter: (value, ctx) => {
                const dataset = ctx.chart.data.datasets[0];
                const total = dataset.data.reduce((acc, data) => acc + data, 0);
                const percentage = Math.round((value / total) * 100);
                return percentage + '%';
            },
            font: {
                size: 16,
                weight: 'bold',
            },
            color: '#000000'
        }
    }
}

const configOtherSchool = {
    type: 'pie',
    data: dataOtherSchool,
    options: optionOtherSchool,
    plugins: [ChartDataLabels]
}

const otherSchoolChart = new Chart(
    document.getElementById('otherSchoolChart'),
    configOtherSchool
);

document.getElementById('chartSelector').addEventListener('change', function() {
    // Hide all divs
    document.querySelectorAll('.chart-field').forEach(function(div) {
        div.style.display = 'none';
    });

    // Show the selected div
    var selectedDiv = document.getElementById(this.value);
    if (selectedDiv) {
        selectedDiv.style.display = 'block';
    }
});