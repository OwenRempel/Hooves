import { useParams } from 'react-router-dom'

function Company() {
    const { id } = useParams();
    return (
        <div>
          {id}
        </div>
    )
}

export default Company
