export default function FormTextarea({ inputLabel, ...rest }) {
    const { name } = rest;
  
    return (
      <div className='inputItem'>
        <label htmlFor={name}>{inputLabel || name}</label>
        <textarea id={name} {...rest} />
      </div>
    );
  }