import { useState, useEffect} from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import Back from '../../Back'
import Form from '../../Form'
import { formHandle } from '../../../lib/FormHandle'


function PenUpdate() {
    const { ID } =  useParams()
    const nav = useNavigate()
    const [FormData, setFormData] = useState({})
    useEffect(() => {
        fetch(process.env.REACT_APP_API_URL+'/pens/info/'+ID+'?token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setFormData(result)
               
              });
      }, [ID])

    console.log(FormData)

    const  submitHandle = async (e) =>{
        e.preventDefault();
        const  res = await formHandle(FormData, e.target, 'PUT');
        if(res.success){
          console.log('Pen Updated successfully')
          e.target.reset()
          nav('/settings/pens')
        }else{
          console.log(res)
        }
    }

    return(
        <>
            <Back link={'/settings/pens'}/>
            {FormData.form &&  <Form {...FormData} onSubmit={submitHandle}/> }

        </>
  )
}

export default PenUpdate