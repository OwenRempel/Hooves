import Form from "../../Components/Form"
import Back from "../../Components/Back";
import Router from 'next/router'

function  add({ formItems }) {
    const { form } = formItems
    const { callBack, passwordCheck } = form;
    const returnFormData = async e => {
        e.preventDefault();
        const FormItem = e.target;
        if(passwordCheck){
          const pass1 = FormItem.querySelector('#'+passwordCheck[0]);
          const pass2 = FormItem.querySelector('#'+passwordCheck[1]);
          if(pass1.value != pass2.value){
            pass1.value = '';
            pass2.value = '';
            alert("Passwords Dont match");
            return
          }
        }
        
        //let FormOut = new FormData();
        let FormOut = {};
        for (let i = 0; i < FormItem.length; i++) {
            const item = FormItem[i];   
            //FormOut.append(item.name, item.value);         
            FormOut[item.name] = item.value;
        }
        const res = await fetch(callBack+'/add', {
            method: 'POST',
            headers:{
              'Content-Type': '"application/x-form-urlencoded"'
            },
            body: JSON.stringify(FormOut)
          });
        
        const Response = await res.json();
        if(Response.error){
          console.log(Response.error);
        }else{
          Router.push('/');
        }
    }
    return (
      <div className="container">
        <Back link='/companies' />
        <Form onSubmit={returnFormData}  {...formItems} />
      </div>
    )
}


export async function getStaticProps() {
    const res = await fetch('http://localhost/companies/add')
    const formItems = await res.json()
    return {
      props: {
        formItems,
      },
    }
  }


export default add

