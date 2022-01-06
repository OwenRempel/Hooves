export default function FormCheckbox({ inputLabel, checkboxTitle, ...rest }) {
    const { name } = rest;
    return (
      <div className='inputItem'>
        <label htmlFor={name}> {inputLabel || name}</label>
          <span className='checkwrap'>
            <input id={name} type="checkbox" {...rest} /> <span className='checkboxtitle'>{checkboxTitle|| name}</span>
          </span> 
      </div>
    );
  }