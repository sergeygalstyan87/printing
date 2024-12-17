
const data = {
  labels: ['Jan','Feb','Mar','Apr','May','June'],
  datasets: [{
    label: 'My First Dataset',
    data: [65, 59, 80, 81, 56, 55, 40],

    borderWidth: 1
  }]
};

let chart = new Chart("#monthly-chart", {
  type: 'bar',
  data: data,
  options: {
    layout: {
      padding: 20
    }
  }
});
