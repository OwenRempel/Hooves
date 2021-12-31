import Form from "../../Components/Form"
import Router from 'next/router'

function  add({ formItems }) {
    const { callBack } = formItems;
    const returnFormData = async e => {
        e.preventDefault();
        const FormItem = e.target;
        //let FormOut = new FormData();
        let FormOut = {};
        for (let i = 0; i < FormItem.length; i++) {
            const item = FormItem[i];   
            //FormOut.append(item.name, item.value);         
            FormOut[item.name] = item.value;
        }
        console.log(FormOut)
        const res = await fetch(callBack, {
            method: 'POST',
            headers:{
              'Content-Type': '"application/x-form-urlencoded"'
            },
            body: JSON.stringify(FormOut)
          });
        
        const Response = await res.json();
        console.log(Response);
        e.target.reset();
        Router.push('/');
    }
    return <Form onSubmit={returnFormData}  {...formItems} />
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

