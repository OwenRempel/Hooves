import { useParams, Link, useSearchParams } from 'react-router-dom';
import { useState, useEffect} from 'react';

import DisplayItems from '../../DisplayItems';
import Back from '../../Back'

//TODO: Add Images

//TODO: Add buttons for groups and moving pens when those features get done


function Cow() {
    const { ID } = useParams();
    const [Cow, setCow] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/cattle/'+ID,{
          headers:{
            'Authorization': 'Bearer '+localStorage.getItem('Token'),
          }
      })
            .then(response => response.json())
            .then(result => {
              setCow(result)
              
            })
    }, [ID]);

    const [searchParams ] = useSearchParams();

    const back = searchParams.get('group-back')

    return (
        <>
            {Cow.Data &&
            <div className='viewWrap'>
                <div className="cowMenu">
                    <Back link={back ? '/groups/entries/'+back : '/cows/'} />
                    <Link to={`/cows/update/${ID}`}>
                        <button className='btn'>Edit</button>
                    </Link>
                    <Link to={`/cows/weight/add/${ID}`}>
                        <button className='btn'>Add Weight</button>
                    </Link>
                    <Link to={`/cows/medical/add/${ID}`}>
                        <button className='btn'>Add Medicine</button>
                    </Link>
                    <Link to={`/cows/delete/${ID}`}>
                        <button className='btn no-btn'>Delete</button>
                    </Link>
                </div>
                <DisplayItems data={Cow}/>
            </div>
            } 
            {!Cow.Data &&
                <>
                    <Back link={back ? '/groups/entries/'+back : '/cows/'} />
                    <h1>404</h1>
                    <h4>That cow doesn't exist</h4>
                </> 
            }       
        </>
    )
}

export default Cow
