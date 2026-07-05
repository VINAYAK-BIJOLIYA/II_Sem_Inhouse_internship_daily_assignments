const students = [
  { id:"STU-1042", name:"Meera Nair", dept:"Computer Science", year:"3rd Year", cgpa:9.42, email:"meera.nair@campus.edu", phone:"+91 98765 43210", bio:"Builds distributed systems for fun; currently deep in a compiler-design side project.", skills:["Rust","Distributed Systems","Compilers"] },
  { id:"STU-1043", name:"Arjun Verma", dept:"Mechanical Engg.", year:"4th Year", cgpa:7.85, email:"arjun.verma@campus.edu", phone:"+91 98765 11223", bio:"Captain of the SAE Baja team; obsessed with suspension geometry.", skills:["CAD","Thermodynamics","SolidWorks"] },
  { id:"STU-1044", name:"Priya Sharma", dept:"Computer Science", year:"2nd Year", cgpa:9.11, email:"priya.sharma@campus.edu", phone:"+91 98765 33445", bio:"Runs the campus ML reading group and interns remotely on NLP tooling.", skills:["Python","NLP","PyTorch"] },
  { id:"STU-1045", name:"Rohan Gupta", dept:"Electrical Engg.", year:"3rd Year", cgpa:6.42, email:"rohan.gupta@campus.edu", phone:"+91 98765 55667", bio:"Retaking circuits II but building a solid synth from scratch in spare time.", skills:["Embedded C","Analog Circuits"] },
  { id:"STU-1046", name:"Ananya Iyer", dept:"Civil Engineering", year:"4th Year", cgpa:8.63, email:"ananya.iyer@campus.edu", phone:"+91 98765 77889", bio:"Thesis on low-carbon concrete alternatives; loves fieldwork over lectures.", skills:["Structural Analysis","AutoCAD"] },
  { id:"STU-1047", name:"Vikram Singh", dept:"Computer Science", year:"1st Year", cgpa:8.05, email:"vikram.singh@campus.edu", phone:"+91 98765 99001", bio:"Fresh off a national coding olympiad podium finish.", skills:["C++","Competitive Programming"] },
  { id:"STU-1048", name:"Kavya Reddy", dept:"Electronics", year:"3rd Year", cgpa:9.78, email:"kavya.reddy@campus.edu", phone:"+91 98765 22114", bio:"Published undergrad research on CRISPR delivery mechanisms.", skills:["Molecular Biology","Lab Research"] },
  { id:"STU-1049", name:"Devansh Patel", dept:"Mechanical Engg.", year:"2nd Year", cgpa:7.21, email:"devansh.patel@campus.edu", phone:"+91 98765 66778", bio:"Restoring a vintage motorcycle as a personal thermodynamics lab.", skills:["Manufacturing","3D Printing"] },
  { id:"STU-1050", name:"Sneha Kulkarni", dept:"Electrical Engg.", year:"4th Year", cgpa:8.94, email:"sneha.kulkarni@campus.edu", phone:"+91 98765 44556", bio:"Designs power electronics for the campus solar car project.", skills:["Power Systems","MATLAB"] },
  { id:"STU-1051", name:"Aditya Malhotra", dept:"Computer Science", year:"4th Year", cgpa:6.98, email:"aditya.malhotra@campus.edu", phone:"+91 98765 88990", bio:"Splits time between coursework and a freelance web dev practice.", skills:["JavaScript","React","Node.js"] },
  { id:"STU-1052", name:"Ishita Bose", dept:"Civil Engineering", year:"1st Year", cgpa:9.35, email:"ishita.bose@campus.edu", phone:"+91 98765 12321", bio:"Placed top of the incoming cohort; keen on sustainable urban planning.", skills:["Urban Planning","GIS"] },
  { id:"STU-1053", name:"Karan Mehta", dept:"Electronics", year:"2nd Year", cgpa:7.63, email:"karan.mehta@campus.edu", phone:"+91 98765 65432", bio:"Volunteers weekends at a rural health diagnostics clinic.", skills:["Biostatistics","Genomics"] }
];

let activeMin = 0, activeMax = 10;

function sealClass(cgpa){
  if(cgpa >= 9) return "seal-gold";
  if(cgpa >= 8) return "seal-silver";
  return "seal-bronze";
}
function sealLabel(cgpa){
  if(cgpa >= 9) return "HONORS";
  if(cgpa >= 8) return "DIST.";
  if(cgpa >= 7) return "MERIT";
  return "PASS";
}
function initials(name){
  return name.split(" ").map(w => w[0]).join("").slice(0,2).toUpperCase();
}

function renderCards(list){
  const $container = $("#cardContainer");
  $container.empty();

  if(list.length === 0){
    $("#emptyState").removeClass("d-none");
  } else {
    $("#emptyState").addClass("d-none");
  }

  list.forEach(s => {
    const card = `
      <div class="col-sm-6 col-lg-4">
        <div class="id-card" data-id="${s.id}">
          <div class="punch-hole"></div>
          <div class="d-flex align-items-start gap-3">
            <div class="avatar-badge">${initials(s.name)}</div>
            <div>
              <p class="stu-name">${s.name}</p>
              <div class="stu-id">${s.id}</div>
              <div class="stu-dept">${s.dept} &middot; ${s.year}</div>
            </div>
          </div>

          <div class="cgpa-seal ${sealClass(s.cgpa)}">
            <span class="num">${s.cgpa.toFixed(2)}</span>
            <span class="lbl">${sealLabel(s.cgpa)}</span>
          </div>

          <button class="toggle-details-btn" type="button">
            <span class="txt">View details</span>
            <span class="arrow">&#9662;</span>
          </button>

          <div class="details-panel">
            <dl class="mb-0">
              <dt>Email</dt><dd>${s.email}</dd>
              <dt>Phone</dt><dd>${s.phone}</dd>
              <dt>About</dt><dd>${s.bio}</dd>
              <dt>Skills</dt>
              <dd>${s.skills.map(sk => `<span class="skill-tag">${sk}</span>`).join("")}</dd>
            </dl>
          </div>
        </div>
      </div>`;
    $container.append(card);
  });

  $("#resultCount").text(list.length);
}

function populateDepartments(){
  const depts = [...new Set(students.map(s => s.dept))].sort();
  const $sel = $("#deptFilter");
  depts.forEach(d => $sel.append(`<option value="${d}">${d}</option>`));
}

function applyFilters(){
  const query = $("#searchInput").val().trim().toLowerCase();
  const dept = $("#deptFilter").val();
  const sortBy = $("#sortFilter").val();

  let filtered = students.filter(s => {
    const matchesQuery = !query ||
      s.name.toLowerCase().includes(query) ||
      s.id.toLowerCase().includes(query);
    const matchesDept = !dept || s.dept === dept;
    const matchesCgpa = s.cgpa >= activeMin && s.cgpa <= activeMax;
    return matchesQuery && matchesDept && matchesCgpa;
  });

  if(sortBy === "name"){
    filtered.sort((a,b) => a.name.localeCompare(b.name));
  } else if(sortBy === "cgpa-desc"){
    filtered.sort((a,b) => b.cgpa - a.cgpa);
  } else if(sortBy === "cgpa-asc"){
    filtered.sort((a,b) => a.cgpa - b.cgpa);
  }

  renderCards(filtered);
}

$(function(){
  populateDepartments();
  renderCards(students);

  // Search box (live)
  $("#searchInput").on("input", applyFilters);

  // Department + sort dropdowns
  $("#deptFilter, #sortFilter").on("change", applyFilters);

  // CGPA range chips
  $(".cgpa-chip").on("click", function(){
    $(".cgpa-chip").removeClass("active");
    $(this).addClass("active");
    activeMin = parseFloat($(this).data("min"));
    activeMax = parseFloat($(this).data("max"));
    applyFilters();
  });

  // jQuery: expand / collapse student details (event delegation, since cards are re-rendered)
  $("#cardContainer").on("click", ".toggle-details-btn", function(){
    const $btn = $(this);
    const $panel = $btn.closest(".id-card").find(".details-panel");

    $panel.slideToggle(220);
    $btn.toggleClass("open");
    $btn.find(".txt").text($btn.hasClass("open") ? "Hide details" : "View details");
  });
});