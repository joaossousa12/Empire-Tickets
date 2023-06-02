function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }

  function showFaq(id) {
    const answer = document.getElementById(id);
    const button = document.getElementById('show'+id);
    if(answer.classList.contains('answer')){
      button.value = 'Show less';
    }else{
      button.value = 'Show more';
    }
    answer.classList.toggle('answer');
  }
  

function showDesc(){
    const elements = document.querySelectorAll('.ticket');
    for(const element of elements){
        element.addEventListener('click', function(){
            const ans = element.querySelectorAll('#description');
            ans[0].classList.toggle('description');
            
        })
    }
}

function addRemoveAttr(id) {
    let contenteditable = document.getElementById('edit').contentEditable;
    if (contenteditable == 'inherit' || contenteditable == 'false') {
       document.getElementById('edit').contentEditable = true;
       document.getElementById('edit').style.borderStyle = "solid";
       document.getElementById('edit').style.borderColor = "#f2f2f2";
       document.getElementById('edit').style.borderRadius = "10px";
       document.getElementById('edit').style.padding = "5px";
       document.getElementById('editDesc').value= 'Save'
    } else {
       document.getElementById('edit').contentEditable = false;
       editDescription(id, document.getElementById('edit').textContent);
       document.getElementById('edit').style.border = "none";
       document.getElementById('editDesc').value= 'Edit'
       addStatustoTicket(id, 'Updated description ');
    }
 }

 function editDescription(paragraphId, newText) {
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_tickets.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Description updated in database.');
      }
    };
    const requestBody = { id: paragraphId, description: newText };
    xhr.send(encodeForAjax(requestBody));
  }


  function newMessage(author, ticket){

    let content = document.getElementById('content').textContent;
    if(content != ''){

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../api/api_add_message.php', true );
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log('New Message in database.');
          updateMessages(ticket);
        }
      };
      const requestBody = { author: author, content: content, ticket: ticket };
      xhr.send(encodeForAjax(requestBody));
    }
  }

  
function updateMessages(ticket) {

  if (!ticket) {
    console.error('Ticket is not defined or is null/undefined');
    return;
  }
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api_get_messages.php?ticket_id=' + ticket, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const messagesList = document.getElementById('messages');
        messagesList.innerHTML = xhr.responseText;
        const content = document.getElementById('content');
        content.textContent = '';
        scrollBar();
      }
    };
    xhr.send();
  }


  function scrollBar(){
    let msgbox = document.getElementById('messages');
        msgbox.scrollTop = msgbox.scrollHeight;
  }

  function updatePriority(ticket){

    let prio = document.getElementById('priority').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_priority.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Priority updated in database.');
        addStatustoTicket(ticket, 'Updated priority to  ' + prio)

      }
    };
    const requestBody = { id: ticket, priority : prio };
    xhr.send(encodeForAjax(requestBody));
  }

  function updateRole(user) {
    let rol = document.getElementById('role' + user).value;
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_role.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Role updated in database.');
      }
    };
  
    const requestBody = { id: user, role: rol };
    xhr.send(encodeForAjax(requestBody));
  }

  function updateDepartment(ticket){

    let department = document.getElementById('department').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_dptmt.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Department updated in database.');

        addStatustoTicket(ticket, 'Changed department of ticket to ' + department)
      }
    };
    const requestBody = { id: ticket, department: department };
    xhr.send(encodeForAjax(requestBody));
  }

  function updateAgentDepartment(user){

    let department = document.getElementById('department' + user).value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_agntdptmt.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Agent department updated in database.');
      }
    };
    const requestBody = { id: user, department: department };
    xhr.send(encodeForAjax(requestBody));
  }

  function assignTicketTo(ticket){

    let agent = document.getElementById('assignTicket').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_agent.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Agent updated in database.');
        setStatus('Assigned', ticket)
      }
    };
    const requestBody = { id: ticket, agent: agent };
    xhr.send(encodeForAjax(requestBody));
  
  }

  function setStatus(status, ticket){
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_set_status.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Status updated in database.');
        const elements = document.getElementsByClassName('status');

        while(elements.length > 0){
          elements[0].parentNode.removeChild(elements[0]);
        }
        
        addStatustoTicket(ticket, 'Set tickets status to ' + status)
      }
    };
    const requestBody = { id: ticket, status: status};
    xhr.send(encodeForAjax(requestBody));
  }

  function openHashtagSearch(ticket){
    const hashtags = document.getElementById('hashtags');
    hashtags.innerHTML = '<input type="text" id="search-input" /><div id="autocomplete-results"></div>';

    const searchInput = document.getElementById('search-input');
    const autocompleteResults = document.getElementById('autocomplete-results');

    searchInput.addEventListener('input', () =>{
      const name = searchInput.value;

      fetch(`../api/api_get_hashtags.php?name=${encodeURIComponent(name)}`)
    .then(response => response.json())
    .then(results => {
      autocompleteResults.innerHTML = '';
      results.forEach(result => {
        const suggestion = document.createElement('button');

        suggestion.textContent = result;
        const addHashtag = 'addHashtag(' + ticket + ');'; 
        suggestion.setAttribute('onclick', addHashtag);
        autocompleteResults.appendChild(suggestion);
      });
    })
    .catch(error => {
      console.error('Error:', error);
    });
    });
    
  }

  function addHashtag(ticket){
    const hashtag = document.getElementById('autocomplete-results').textContent;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_add_hashtag.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        updateHashtags(ticket);
        addStatustoTicket(ticket, 'Added hashtag '  + hashtag )
      }
    }
    xhr.send(encodeForAjax({ticket: ticket, hashtag : hashtag}))
  }

  function updateHashtags(ticket){
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api_get_hash_ticket.php?id='+ticket, true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log('../api/api_get_hash_ticket.php?id='+ticket);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const hashtags = document.getElementById('hashtags');
        hashtags.innerHTML = xhr.responseText;
      }
    }
    xhr.send();
  }

  function addStatustoTicket(ticket, status){
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_update_ticketstatus.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        
      }
    }
    xhr.send(encodeForAjax({ticket: ticket, status: status}))
  }



  function openEditFaq(id){

    showFaq(id);

    const answerFaq = document.getElementById(id);
    answerFaq.classList.toggle('editing');
    answerFaq.contentEditable = true;
    const saveButton= document.getElementById('saveButton'+id);
    saveButton.classList.toggle('editing');
  }

  function editFaq(id){

    const content = document.getElementById(id).textContent;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../api/api_update_faq.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        
      }
    }
    xhr.send(encodeForAjax({id: id, content: content}))

    showFaq(id);

    const answerFaq = document.getElementById(id);
    answerFaq.classList.toggle('editing');
    answerFaq.contentEditable = false;

    const saveButton= document.getElementById('saveButton'+id);
    saveButton.classList.remove('editing');
  }

  function answerWithFaq(){
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api_get_all_faqs.php', true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const container = document.getElementById('messages');
        container.innerHTML= xhr.responseText;
      }
    }
    xhr.send();
  }

  function writeFaqMessage(id){
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/api_get_faq.php?id='+id, true );
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const container = document.getElementById('content');
        container.textContent = xhr.responseText;
        
      }
    }
    xhr.send();
  }


  function descriptionExtend(){
    const container = document.getElementById('mobile');
    container.classList.toggle('mobile');
  }

  function openTicket(){
    const button = document.getElementById('newTicket');
    button.textContent= 'Colapse';
    const form = document.getElementById('ticketForm');
    form.classList.toggle('hide');
  }

scrollBar();