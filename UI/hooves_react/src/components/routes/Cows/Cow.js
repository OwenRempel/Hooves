import { useParams } from 'react-router-dom';
import { useState, useEffect } from 'react';
import DisplayItems from '../../DisplayItems';
function Cow() {
    const { ID } = useParams();
    const [Cow, setCow] = useState({});
    useEffect(() => {
      fetch('http://localhost/cattle/'+ID+'?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setCow(result)
            })
    }, [ID]);

    console.log(Cow)
    return (
        <div>
            {Cow.Data &&
                <DisplayItems data={Cow}/>
            }        
        </div>
    )
}

export default Cow
