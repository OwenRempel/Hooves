import Form from "../../Components/Form"

function  add({ formItems }) {
    const { callBack } = formItems;
    const returnFormData = async e => {
        e.preventDefault();
        const FormItem = e.target;
        let FormOut = new FormData();
        //let FormOut = {};
        for (let i = 0; i < FormItem.length; i++) {
            const item = FormItem[i];   
            FormOut.append(item.name, item.value);         
            //FormOut[item.name] = item.value;
        }
        console.log(FormOut)
        const res = await fetch('http://localhost/company/add', {
            method: 'POST',
            body: FormOut
          });
        
        const formdata = await res.text();
        console.log(formdata);
    }
    return <Form onSubmit={returnFormData}  {...formItems} />
}


export async function getStaticProps() {
    const res = await fetch('http://localhost/company/add')
    const formItems = await res.json()
    return {
      props: {
        formItems,
      },
    }
  }


export default add

