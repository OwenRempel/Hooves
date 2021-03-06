export async function formHandle(formData, FormItem, methodType='POST', ID){
    const { form } = formData
    const { callBack, passwordCheck } = form;
    let url
    if(passwordCheck){
    const pass1 = FormItem.querySelector('#'+passwordCheck[0]);
    const pass2 = FormItem.querySelector('#'+passwordCheck[1]);
        if(pass1.value !== pass2.value){
            pass1.value = '';
            pass2.value = '';
            alert("Passwords Dont match");
            return
        }
    }
    let FormOut = {};
    for (let i = 0; i < FormItem.length; i++) {
        const item = FormItem[i];   
        //FormOut.append(item.name, item.value);         
        FormOut[item.name] = item.value;
    }
    if(ID){
         url =  callBack+'/'+ID
    }else{
         url = callBack
    }
    const res = await fetch(url, {
        method: methodType,
        headers:{
        'Content-Type': '"application/x-form-urlencoded"',
        'Authorization': 'Bearer '+localStorage.getItem('Token')
        },
        body: JSON.stringify(FormOut)
    });
    
    const Response = await res.json();
    return Response
    
}