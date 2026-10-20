jQuery(function($){
 $('#mah-er-form').on('submit',function(e){
   e.preventDefault();
   const form=this, msg=$('#mah-er-message'), data=new FormData(form);
   msg.text('Submitting...');
   fetch(MAHER.rest+'register',{
     method:'POST',body:data,headers:{'X-WP-Nonce':MAHER.nonce}
   }).then(r=>r.json()).then(x=>{
     if(x.success){msg.html('<strong>Success!</strong> Registration ID: '+x.registration_id); form.reset();}
     else msg.text(x.message||'Registration failed.');
   }).catch(()=>msg.text('Network/server error. Please try again.'));
 });
});
