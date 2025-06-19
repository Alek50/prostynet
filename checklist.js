const API_URL = "./backend/api.php";

async function loadChecklist() {
  const res = await fetch(API_URL);
  const data = await res.json();
  const list = document.getElementById("checklist");
  list.innerHTML = "";
  data.forEach(item => {
    const li = document.createElement("li");
    li.textContent = (item.done ? "✔️ " : "❌ ") + item.content;
    list.appendChild(li);
  });
}

async function addItem() {
  const input = document.getElementById("newItem");
  if (!input.value) return;
  await fetch(API_URL, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ content: input.value })
  });
  input.value = "";
  loadChecklist();
}

window.onload = loadChecklist;