async function loadResume() {
  try {
    const res = await fetch('resume.json');
    if (!res.ok) throw new Error('Failed to load resume.json');
    const data = await res.json();

    document.getElementById('name').textContent = data.name || '';
    document.getElementById('title').textContent = data.title || '';
    const contactEl = document.getElementById('contact');
    contactEl.textContent = `${data.contact.email || ''} | ${data.contact.phone || ''} | ${data.contact.location || ''}`;
    document.getElementById('summary').innerHTML = (data.summary || '').replace(/\n/g, '<br>');

    const expRoot = document.getElementById('experience-list');
    expRoot.innerHTML = '';
    (data.experience || []).forEach(job => {
      const div = document.createElement('div');
      div.className = 'job';
      const h3 = document.createElement('h3');
      h3.textContent = `${job.title} — ${job.company}`;
      const dates = document.createElement('p');
      dates.className = 'dates';
      dates.textContent = `${job.start || ''} — ${job.end || ''}`;
      const desc = document.createElement('p');
      desc.innerHTML = (job.description || '').replace(/\n/g, '<br>');
      div.appendChild(h3);
      div.appendChild(dates);
      div.appendChild(desc);
      expRoot.appendChild(div);
    });

    const eduRoot = document.getElementById('education-list');
    eduRoot.innerHTML = '';
    (data.education || []).forEach(edu => {
      const div = document.createElement('div');
      div.className = 'edu';
      const h3 = document.createElement('h3');
      h3.textContent = `${edu.degree} — ${edu.institution}`;
      const year = document.createElement('p');
      year.className = 'dates';
      year.textContent = edu.year || '';
      div.appendChild(h3);
      div.appendChild(year);
      eduRoot.appendChild(div);
    });

    const skillsRoot = document.getElementById('skills-list');
    skillsRoot.innerHTML = '';
    (data.skills || []).forEach(s => {
      const li = document.createElement('li');
      li.textContent = s;
      skillsRoot.appendChild(li);
    });

  } catch (err) {
    console.error(err);
    document.getElementById('resume-root').innerText = 'Error loading resume.';
  }
}

document.addEventListener('DOMContentLoaded', loadResume);
